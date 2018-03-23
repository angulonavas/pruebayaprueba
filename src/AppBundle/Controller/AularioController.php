<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AularioController extends Controller {
    
    /**
     * @Route("/asignaturas/{asignatura}", name="contenido_asignatura")
     */
    public function cargar_asignaturaAction(Request $request) {
        echo 'q1';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/videos/{categoria}", name="contenido_videos_categoria")
     */
    public function cargar_videos_categoriaAction(Request $request) {
        echo 'q3';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos", name="contenido_documentos_asignatura")
     */
    public function cargar_documentos_asignaturaAction(Request $request) {
        echo 'q4';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos/subir", name="contenido_subir_documento")
     */
    public function subir_documentoAction(Request $request) {
        echo 'q5';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }    

    /**
     * @Route("/asignaturas/{asignatura}/{temario}", name="contenido_indice_temario")
     */
    public function cargar_indice_temarioAction(Request $request) {
        echo 'q2';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }   

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/modo", name="contenido_cambiar_modo")
     */
    public function cambiar_modo_estudioAction(Request $request) {
        echo 'q7';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }     

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/guardar", name="contenido_guardar_guia")
     */
    public function guardar_cookie_guiaAction(Request $request) {
        echo 'q8';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }    

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/examen", name="contenido_examen")
     */
    public function cargar_examenAction(Request $request) {
        echo 'q9';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    } 

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/examen/evaluar", name="contenido_evaluar_examen")
     */
    public function evaluar_examenAction(Request $request) {
        echo 'q10';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }       

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/enviar", name="contenido_enviar_consulta")
     */
    public function enviar_consultaAction(Request $request) {
        echo 'q12';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }    

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/{N}", name="contenido_consultas_seccion")
     */
    public function cargar_consultas_seccionAction(Request $request) {
        echo 'q11';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}", name="contenido_cargar_seccion")
     */
    public function cargar_seccion_temarioAction(Request $request) {
        echo 'q6.1';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/aula/{asignatura}/temarios", name="contenido_cargar_temarios")
     */
    public function cargar_temarios_asignaturaAction(Request $request) {
        echo 'q6';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }   

}
