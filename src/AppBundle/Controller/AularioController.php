<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Cookie;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Consulta;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use AppBundle\Entity\Pregunta_Examen;
use AppBundle\Entity\Opcion_Pregunta;

use AppBundle\Form\ConsultaType;

use AppBundle\Service\AccesoAulas;
use AppBundle\Service\ObjetoUrl;
use AppBundle\Service\GuiaSeccionService;


class AularioController extends Controller {
         
    /**
     * @Route("/aula/{asignatura}/{temario}/secciones", name="contenido_cargar_secciones")
     */
    public function cargar_secciones_temarioAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, GuiaSeccionService $guia, $asignatura, $temario) {
        
        try {
            // comprobamos que tanto la asignatura como el temario existen
            $asignatura = $objeto->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("Lo sentimos, la asignatura no está disponible", 1);
            $temario = $objeto->buscar_temario($asignatura, $temario);
            if (!$temario) throw new Exception("Lo sentimos, el temario no está disponible", 1);

            // comprobamos si el usuario tiene acceso
            $acceso = $acceso_aulas->acceso($asignatura, $temario);
            if (!$acceso) throw new Exception("Acceso denegado", 1);

            // cargamos el estado de matriculación del usuario con respecto al temario
            $em = $this->getDoctrine()->getManager();
            $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
            $temario->setMatriculado($matriculado);

            // buscamos todas las secciones dle temario
            $secciones = $em->getRepository(Seccion::class)->buscarTodos($temario); 
            $temario->setSecciones($secciones);

            // si el usuario no está matriculado en el temario no podrá elegir entre guiado y no guiado
            $guia_seccion = null;

            if ($temario->getMatriculado()) {
                // habilitamos todas las secciones.
                // WARNING!: si por alguna razón se sincronizara después doctrine, todas las secciones quedarían matriculadas 
                foreach ($temario->getSecciones() as $seccion) $seccion->setMatriculado(true);

                // dado que el usuario está matriculado en el temario, se comprueba si existe guia
                // si existe guia para el temario se recupera la sección que marca la guía.
                // si no existe guia, se crea una nueva que apunta a la primera sección.
                if ($guia->existeGuia($temario)) $guia_seccion = $guia->getGuia($temario);
                else $guia->setGuia($temario->getSecciones()[0]);

            } else {
                foreach ($temario->getSecciones() as $seccion) {
                    $matriculado = $em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->getUser()); 
                    $seccion->setMatriculado($matriculado);
                }
            }

            return $this->render('Aula/acceso_secciones.html.twig', [
                'asignatura' => $asignatura,
                'temario' => $temario,
                'guia' => $guia_seccion
            ]);
        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        }                 
    } 

    /**
     * @Route("/aula/{asignatura}/{temario}/secciones/toggle", name="contenido_toggle_guia")
     */
    public function toggle_guiaAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, GuiaSeccionService $guia, $asignatura, $temario) {

        try {
            // comprobamos que tanto la asignatura como el temario existen
            $asignatura = $objeto->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("Lo sentimos, la asignatura no está disponible", 1);
            $temario = $objeto->buscar_temario($asignatura, $temario);
            if (!$temario) throw new Exception("Lo sentimos, el temario no está disponible", 1);

            // ejecutamos el toggle
            $guia->toggleGuiado($temario);

            // devolvemos el response que carga las secciones del temario
            return $this->cargar_secciones_temarioAction(
                $request, $acceso_aulas, $objeto, $guia, $asignatura->getTitulo(), $temario->getTitulo());

        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}", name="contenido_cargar_seccion")
     */
    public function cargar_seccion_temarioAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, GuiaSeccionService $guia, $asignatura, $temario, $seccion) {

        try {

            // comprobamos que asignatura, temario y sección son correctos
            // también comprobamos que el usuario tenga acceso
            $asignatura = $objeto->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("Lo sentimos, la asignatura no está disponible", 1);
            $temario = $objeto->buscar_temario($asignatura, $temario);
            if (!$temario) throw new Exception("Lo sentimos, el temario no está disponible", 1);
            $seccion = $objeto->buscar_seccion($asignatura, $temario, $seccion);
            if (!$seccion) throw new Exception("Lo sentimos, la sección no está disponible", 1);
            $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);
            if (!$acceso) throw new Exception("Lo sentimos, No tiene acceso a la sección. Puedes matricularte desde el catálogo", 1);

            // Comprobamos si está o no guiado el flujo de estudio
            // si está guiado, se añade la sección actual a la guia como nuevo marcador
            // si no está guiado o no existe la guia, se activa el índice de secciones
            $indice_secciones = false;
            if ($guia->existeGuia($temario)) {
                $guia_temario = $guia->getGuia($temario);
                if ($guia_temario['guiado']) {
                    $guia->setGuia($seccion);
                    $guia_temario = $guia->getGuia($temario);
                } else $indice_secciones = true;
            } else $indice_secciones = true;

            // obtenemos la cantidad de consultas que tiene la sección
            $num_consultas = $this->getDoctrine()->getManager()->getRepository(Consulta::class)->numConsultas($seccion);
        
            // preparando el array de parámetros
            $parametros_response = [
                'asignatura' => $asignatura,
                'temario' => $temario,
                'seccion' => $seccion,
                'num_consultas' => $num_consultas,
                'guia' => $guia_temario
            ];

            /* 
             * si la sección actual es teórica se renderiza la sección con la plantilla a renderizar
             * si no se buscarán las preguntas y las opciones de cada una de ellas y se asignarán a los parámetros de response
             */

            // si no es téórica es que es examen
            if (!$seccion->getTeorica()) {
                // creamos las preguntas con las opciones del examen
                $preguntas = $this->getDoctrine()->getManager()->getRepository(Pregunta_Examen::class)->findBySeccion($seccion, 
                    ['orden' => 'ASC']
                );

                // por cada pregunta buscamos las opciones y las asignamos
                foreach ($preguntas as $pregunta) {
                    $opciones = $this->getDoctrine()->getManager()->getRepository(Opcion_Pregunta::class)->buscarPorPregunta($pregunta);
                    $pregunta->setOpciones($opciones);
                }

                // Asignamos las preguntas a los parámetros para el response
                $parametros_response['preguntas'] = $preguntas;
            }

            // renderizamos la sección
            return $this->render('Aula/seccion.html.twig', $parametros_response);
            //return $this->render('Contenido/acceso_denegado.html.twig', ['error' => 'Acceso no']);
        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        } 
    }

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas", name="contenido_cargar_consultas")
     */
    public function cargar_consultas_seccionAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, GuiaSeccionService $guia, $asignatura, $temario, $seccion) {

        try {
            // comprobamos que asignatura, temario y sección son correctos
            // también comprobamos que el usuario tenga acceso
            $asignatura = $objeto->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("Lo sentimos, la asignatura no está disponible", 1);
            $temario = $objeto->buscar_temario($asignatura, $temario);
            if (!$temario) throw new Exception("Lo sentimos, el temario no está disponible", 1);
            $seccion = $objeto->buscar_seccion($asignatura, $temario, $seccion);
            if (!$seccion) throw new Exception("Lo sentimos, la sección no está disponible", 1);

            // buscamos las consultas de la sección
            $consultas = $this->getDoctrine()->getManager()->getRepository(Consulta::class)->buscarTodasSeccion($seccion);

            // definición del formulario para envío de nueva consulta    
            $consulta = new Consulta();
            $form = $this->createForm(ConsultaType::class, $consulta);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $consulta = $form->getData();
                $consulta->setUsuario($this->getUser());
                $consulta->setSeccion($seccion);
                $consulta->setFecha(new \DateTime());
                $consulta->setEstado('PENDIENTE');

                $em->persist($consulta);
                $em->flush();
            }

            return $this->render('Aula/consultas.html.twig', [
                'asignatura' => $asignatura,
                'temario' => $temario,
                'seccion' => $seccion,
                'consultas' => $consultas,
                'form_consulta' => $form->createView()
            ]);
        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        }             
    }
    /**
     * @Route("/aula/{asignatura}/temarios", name="contenido_cargar_temarios")
     */
    public function cargar_temarios_asignaturaAction(Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, $asignatura) {
        
        try {
            // comprobamos que la asignatura existe y que el usuario tiene acceso a la misma
            $asignatura = $objeto->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("Lo sentimos, la asignatura no está disponible", 1);
            $acceso = $acceso_aulas->acceso($asignatura);
            if (!$acceso) throw new Exception("Lo sentimos, No tiene acceso al aula. Puede matricularse desde el catálogo", 1);

            // comprobamos los temarios en los que está matriculado el usuario
            $em = $this->getDoctrine()->getManager();
            foreach ($asignatura->getTemarios() as $temario) {
                $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
                $temario->setMatriculado($matriculado);

                // si el usuario está matriculado en alguna sección del temario también marcamos el temario como matriculado
                if (!$temario->getMatriculado()) {
                    foreach ($temario->getSecciones() as $seccion) {
                        $matriculado = $em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->getUser()); 
                        $temario->setMatriculado($matriculado);
                        if ($temario->getMatriculado()) break;
                    }
                }
            }
      
            return $this->render('Aula/acceso_temarios.html.twig', [
                'asignatura' => $asignatura
            ]);
        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        }         
    }   

}
