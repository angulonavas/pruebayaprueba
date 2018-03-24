<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalendarioController extends Controller {
    /**
     * @Route("/calendario", name="calendario_cargar")
     */
    public function cargarAction(Request $request) {
        return $this->render('Contenido/calendario.html.twig', []);
    }
}
