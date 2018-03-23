<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContenidoController extends Controller {
    
    /**
     * @Route("/intro", name="contenido_intro")
     */
    public function cargar_introAction(Request $request) {
        echo 'q1';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/", name="contenido_raiz")
     */
    public function cargar_raizAction(Request $request) {
        echo 'q2';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }  

    /**
     * @Route("/nosotros", name="contenido_nosotros")
     */
    public function cargar_examenAction(Request $request) {
        echo 'q3';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    } 

    /**
     * @Route("/colabora", name="contenido_colabora")
     */
    public function evaluar_examenAction(Request $request) {
        echo 'q4';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }       

    /**
     * @Route("/actividad", name="contenido_actividad")
     */
    public function cargar_consultas_seccionAction(Request $request) {
        echo 'q5';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/legal", name="contenido_legal")
     */
    public function enviar_consultaAction(Request $request) {
        echo 'q6';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }    
}
