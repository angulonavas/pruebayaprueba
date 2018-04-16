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

use AppBundle\Form\ConsultaType;

use AppBundle\Service\AccesoAulas;
use AppBundle\Service\ObjetoUrl;


class AularioController extends Controller {
         
    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/guardar", name="contenido_guardar_guia")
     */
    public function guardar_cookie_guiaAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, $asignatura, $temario, $seccion) {

        $response = $this->cargar_seccion_temarioAction($request, $acceso_aulas, $objeto, $asignatura, $temario, $seccion);
        $response->headers->setCookie(new Cookie('marca_seccion', $seccion));
        return $response;
    }    

    /**
     * @Route("/aula/{asignatura}/{temario}/secciones", name="contenido_cargar_secciones")
     */
    public function cargar_secciones_temarioAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, $asignatura, $temario) {
        
        $asignatura = $objeto->buscar_asignatura($asignatura);
        $temario = $objeto->buscar_temario($asignatura, $temario);

        $acceso = $acceso_aulas->acceso($asignatura, $temario);

        if ($acceso) {

            $cookies = $request->cookies;
            if ($cookies->has('marca_seccion')) {
                $seccion = $cookies->get('marca_seccion');
                return $this->cargar_seccion_temarioAction(
                    $request, $acceso_aulas, $objeto, $asignatura->getTitulo(), $temario->getTitulo(), $seccion);
            }

            $em = $this->getDoctrine()->getManager();
            $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
            $temario->setMatriculado($matriculado);

            if ($temario->getMatriculado()) foreach ($temario->getSecciones() as $seccion) $seccion->setMatriculado(true);

            else {
                foreach ($temario->getSecciones() as $seccion) {
                    $matriculado = $em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->getUser()); 
                    $seccion->setMatriculado($matriculado);
                }
            }

            return $this->render('Aula/acceso_secciones.html.twig', [
                'asignatura' => $asignatura,
                'temario' => $temario
            ]);

        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    } 

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}", name="contenido_cargar_seccion")
     */
    public function cargar_seccion_temarioAction(
        Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, $asignatura, $temario, $seccion) {

        $asignatura = $objeto->buscar_asignatura($asignatura);
        $temario = $objeto->buscar_temario($asignatura, $temario);
        $seccion = $objeto->buscar_seccion($asignatura, $temario, $seccion);
        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {
        
            $em = $this->getDoctrine()->getManager();
            $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
            $temario->setMatriculado($matriculado);

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

            // carga de las consultas
            $consultas = $em->getRepository(Consulta::class)->findBySeccion($seccion, 
                ['fecha' => 'DESC']
            ); 
        
            if ($seccion->getTeorica()) {
                return $this->render('Secciones/ID9991.html.twig', [
                    'asignatura' => $asignatura,
                    'temario' => $temario,
                    'seccion' => $seccion,
                    'consultas' => $consultas,
                    'form_consulta' => $form->createView()
                ]);

            } else {
                $preguntas = $em->getRepository(Pregunta_Examen::class)->findBySeccion($seccion, 
                    ['orden' => 'ASC']
                ); 
                return $this->render('Aula/examen.html.twig', [
                    'asignatura' => $asignatura,
                    'temario' => $temario,
                    'seccion' => $seccion,
                    'preguntas' => $preguntas,
                    'consultas' => $consultas,
                    'form_consulta' => $form->createView()
                ]);                
            }

        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    }

    /**
     * @Route("/aula/{asignatura}/temarios", name="contenido_cargar_temarios")
     */
    public function cargar_temarios_asignaturaAction(Request $request, AccesoAulas $acceso_aulas, ObjetoUrl $objeto, $asignatura) {
        
        $asignatura = $objeto->buscar_asignatura($asignatura);
        $acceso = $acceso_aulas->acceso($asignatura);

        if ($acceso) {

            $em = $this->getDoctrine()->getManager();
            foreach ($asignatura->getTemarios() as $temario) {
                $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
                $temario->setMatriculado($matriculado);

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

        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }
    }   

}
