<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AularioController extends Controller {
    
    /**
     * @Route("/asignaturas/{asignatura}", name="contenido_asignatura")
     */
    public function cargar_asignatura_infoAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Asignatura/info_asignatura.html.twig', []);
    }

    /**
     * @Route("/asignaturas/{asignatura}/videos/{categoria}", name="contenido_videos_categoria")
     */
    public function cargar_videos_categoriaAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Asignatura/videos.html.twig', []);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos", name="contenido_documentos_asignatura")
     */
    public function cargar_documentos_asignaturaAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Asignatura/documentos.html.twig', []);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos/subir", name="contenido_subir_documento")
     */
    public function subir_documentoAction(Request $request) {
        echo 'cargando nuevo documento...';
        // replace this example code with whatever you need
        return $this->render('Asignatura/documentos.html.twig', []);
    }    

    /**
     * @Route("/asignaturas/{asignatura}/{temario}", name="contenido_indice_temario")
     */
    public function cargar_indice_temarioAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Asignatura/temario.html.twig', []);
    }   
     
    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/guardar", name="contenido_guardar_guia")
     */
    public function guardar_cookie_guiaAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Aula/seccion.html.twig', []);
    }    

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/examen/evaluar", name="contenido_evaluar_examen")
     */
    public function evaluar_examenAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Aula/examen.html.twig', []);
    }       

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/enviar", name="contenido_enviar_consulta")
     */
    public function enviar_consultaAction(Request $request) {
        // replace this example code with whatever you need
        $examen = false;
        if ($examen) return $this->render('Aula/examen.html.twig', []);
        else return $this->render('Secciones/ID9991.html.twig', []);

    }

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/{id}", name="contenido_cargar_consultas")
     */
    public function cargar_consultas_seccionAction(Request $request) {
        // replace this example code with whatever you need
        $examen = false;
        if ($examen) return $this->render('Aula/examen.html.twig', []);
        else return $this->render('Secciones/ID9991.html.twig', []);

    }

    /**
     * @Route("/aula/{asignatura}/{temario}/secciones", name="contenido_cargar_secciones")
     */
    public function cargar_secciones_temarioAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Aula/acceso_secciones.html.twig', []);
    } 

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}", name="contenido_cargar_seccion")
     */
    public function cargar_seccion_temarioAction(Request $request) {
        // replace this example code with whatever you need
        $examen = false;
        if ($examen) return $this->render('Aula/examen.html.twig', []);
        else return $this->render('Secciones/ID9991.html.twig', []);
    }

    /**
     * @Route("/aula/{asignatura}/temarios", name="contenido_cargar_temarios")
     */
    public function cargar_temarios_asignaturaAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Aula/acceso_temarios.html.twig', []);
    }   

}
