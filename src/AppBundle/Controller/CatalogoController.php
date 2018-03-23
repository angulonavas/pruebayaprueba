<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CatalogoController extends Controller {

    /**
     * @Route("/catalogo/servicios", name="catalogo_servicios")
     */
    public function cargar_serviciosAction(Request $request) {
        echo 'q41';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/catalogo/servicios/incluir/{servicio}", name="catalogo_incluir_servicio")
     */
    public function incluir_servicio_pedidoAction(Request $request) {
        echo 'q40';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }   

    /**
     * @Route("/catalogo/temarios", name="catalogo_temarios")
     */
    public function cargar_temariosAction(Request $request) {
        echo 'q36';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }   

         /**
     * @Route("/catalogo/temarios/incluir/{temario}", name="catalogo_incluir_temario")
     */
    public function incluir_temario_pedidoAction(Request $request) {
        echo 'q35';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/catalogo/temarios/secciones", name="catalogo_secciones")
     */
    public function cargar_secciones_temarioAction(Request $request) {
        echo 'q34';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    } 

    /**
     * @Route("/catalogo/temarios/secciones/buscar/{frase}", name="catalogo_buscar_secciones")
     */
    public function cargar_secciones_frase_busquedaAction(Request $request) {
        echo 'q33';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/catalogo/temarios/secciones/incluir/{seccion}", name="catalogo_incluir_seccion")
     */
    public function incluir_seccion_pedidoAction(Request $request) {
        echo 'q32';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }  

    /**
     * @Route("/catalogo", name="catalogo_cargar")
     */
    public function cargar_catalogoAction(Request $request) {
        echo 'q30';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }  

    /**
     * @Route("/pedido", name="catalogo_pedido")
     */
    public function cargar_pedidoAction(Request $request) {
        echo 'q39';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/pedido/abonar", name="catalogo_abonar")
     */
    public function abonar_matriculaAction(Request $request) {
        echo 'q38';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/factura/{username}/{codigo}", name="catalogo_factura")
     */
    public function recepcionar_pagoAction(Request $request) {
        echo 'q37';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    
    // El siguiente método es el que utilizará el script de cron:

    /**
     * @Route("/catalogo/servicios/eliminar", name="catalogo_eliminar_servicios")
     */
    public function eliminar_servicios_catalogoAction(Request $request) {
        echo 'q31';
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

}
