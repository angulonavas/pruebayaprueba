<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Documento;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use AppBundle\Entity\Temario;

use AppBundle\Form\DocumentoType;

use AppBundle\Service\ObjetoUrl;

class AsignaturaController extends Controller {
    
    /**
     * @Route("/asignaturas/{asignatura}", name="contenido_asignatura")
     */
    public function cargar_asignatura_infoAction(Request $request, ObjetoUrl $objeto, $asignatura) {
        
        $asignatura = $objeto->buscar_asignatura($asignatura);

        return $this->render('Asignatura/info_asignatura.html.twig', [
            'asignatura' => $asignatura
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/videos/{categoria}", name="contenido_videos_categoria")
     */
    public function cargar_videos_categoriaAction(Request $request, ObjetoUrl $objeto, $asignatura, $categoria) {
        
        $asignatura = $objeto->buscar_asignatura($asignatura);  
        $categoria = $objeto->buscar_categoria($asignatura, $categoria);

        return $this->render('Asignatura/videos.html.twig', [
            'asignatura' => $asignatura,
            'categoria' => $categoria
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos", name="contenido_documentos_asignatura")
     */
    public function cargar_documentos_asignaturaAction(Request $request, $asignatura) {

        $em = $this->getDoctrine()->getManager();
        $asignatura = $em->getRepository(Asignatura::class)->findOneByTitulo($asignatura);

        $documento = new Documento();

        $form = $this->createForm(DocumentoType::class, $documento);
        $form->handleRequest($request);

        $mensaje = '';

        if ($form->isSubmitted() && $form->isValid()) {
            
            // cargamos el sistema de ficheros
            $fileSystem = new Filesystem();

            // si no existe el directorio de la asignatura se crea.
            // al indicar 'documentos/' lo estamos creando en la raiz del directorio /web del sistema
            // si quisiéramos que se creara con url absolutas deberiamos indicar '/url/documentos'
            if (!$fileSystem->exists('documentos/'.$asignatura->getTitulo())) {
                $fileSystem->mkdir('documentos/'.$asignatura->getTitulo());
            }

            $documento = $form->getData();
            /*$validator = $this->get('validator');
            $errores = $validator->validate($documento);
            echo count($errores);*/

            $file = $documento->getAttachment();

            // Comprobamos que el nombre del fichero es el adecuado
            if (strlen($file->getClientOriginalName()) > 32) $mensaje = 'El nombre del fichero sólo puede tener 32 caracteres';

            else {
                $extension = $file->guessExtension();
                if ($extension == 'pdf') {

                    // Guardamos el fichero con su nombre original
                    $file->move('documentos/'.$asignatura->getTitulo(), $file->getClientOriginalName());
                    $mensaje = 'Fichero almacendo con éxito';

                    // Almacenando la entrada del documento en BBDD
                    $documento->setNombreFichero($file->getClientOriginalName());
                    $documento->setCorrupto(false);
                    $documento->setPrioridad('NORMAL');
                    $documento->setTipo($extension);
                    $documento->setAsignatura($asignatura);
                    $documento->setUsuario($this->getUser());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($documento);
                    $em->flush();

                } else $mensaje = 'No se ha podido enviar el fichero. Sólo se permite formato PDF';
            }
        }

        return $this->render('Asignatura/documentos.html.twig', [
            'asignatura' => $asignatura,
            'form' => $form->createView(),
            'mensaje' => $mensaje,
            'errores' => null
        ]);
    }  

    /**
     * @Route("/asignaturas/{asignatura}/{temario}", name="contenido_indice_temario")
     */
    public function cargar_indice_temarioAction(Request $request, ObjetoUrl $objeto, $asignatura, $temario) {
        
        $asignatura = $objeto->buscar_asignatura($asignatura);  
        $temario = $objeto->buscar_temario($asignatura, $temario);           

        $em = $this->getDoctrine()->getManager();
        $matriculado = $em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->getUser()); 
        $temario->setMatriculado($matriculado);

        foreach ($temario->getSecciones() as $seccion) {
            $matriculado = $em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->getUser()); 
            $seccion->setMatriculado($matriculado);
        }

        return $this->render('Asignatura/temario.html.twig', [
            'asignatura' => $asignatura,
            'temario' => $temario
        ]);
    }     

}
