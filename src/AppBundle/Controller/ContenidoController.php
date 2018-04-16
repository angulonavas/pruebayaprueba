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
        /*  
            el dominio apuntará directamente a la intro. Con lo cual siempre se cargará esta función.
            Se realizarán las comprobaciones oportunas para ver si se debe mostrar la intro o no.
         */
        $intro = true;
        if ($intro == true) return $this->render('Contenido/intro.html.twig', []);
        else     return $this->redirectToRoute('contenido_raiz');

            //return $this->render('@Seguridad/credenciales.html.twig', []);
    }

    /**
     * @Route("/", name="contenido_raiz")
     */
    public function cargar_raizAction() {  
        return $this->render('Contenido/raiz.html.twig', []);
    }  

    /**
     * @Route("/nosotros", name="contenido_nosotros")
     */
    public function nosotrosAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Contenido/nosotros.html.twig', []);
    } 

    /**
     * @Route("/colabora", name="contenido_colabora")
     */
    public function colaboraAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Contenido/colabora.html.twig', []);
    }       

    /**
     * @Route("/actividad", name="contenido_actividad")
     */
    public function actividadAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Contenido/actividad.html.twig', []);
    }

    /**
     * @Route("/aviso_legal", name="contenido_legal")
     */
    public function aviso_legalAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Contenido/aviso_legal.html.twig', []);
    }    
}
