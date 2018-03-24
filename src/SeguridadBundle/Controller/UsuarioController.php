<?php

namespace SeguridadBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller {
    
    /**
     * @Route("/login", name="usuario_login")
     */
    public function autentificarAction(Request $request) {
        echo '45';
        //return $this->render('@Seguridad/Default/index.html.twig');
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/registro", name="usuario_registro32")
     */
    public function registrarAction(Request $request) {
        echo '40';
        // replace this example code with whatever you need
        return $this->render('@Seguridad/Default/index.html.twig');
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/
    }

    /**
     * @Route("/registro/activar/{username}/{codigo}", name="usuario_activar_registro")
     */
    public function activarAction(Request $request) {
        echo '41';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/olvido", name="usuario_olvido")
     */
    public function recuperar_credencialesAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('@Seguridad/olvido.html.twig', []);
    }

    /**
     * @Route("/recuperacion/{username}/{codigo}", name="usuario_recuperacion")
     */
    public function cambiar_claveAction(Request $request) {
        echo '43';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/perfil/{username}", name="usuario_perfil")
     */
    public function perfilAction(Request $request) {
        echo '44';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
