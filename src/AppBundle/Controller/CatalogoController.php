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
        // replace this example code with whatever you need
        return $this->render('Catalogo/catalogo_servicios.html.twig', []);
    }

    /**
     * @Route("/catalogo/servicios/incluir/{servicio}", name="catalogo_incluir_servicio")
     */
    public function incluir_servicio_pedidoAction(Request $request, $servicio) {
        // replace this example code with whatever you need
        echo $servicio;
        return $this->render('Catalogo/catalogo_servicios.html.twig', []);
    }   

    /**
     * @Route("/catalogo/temarios", name="catalogo_temarios")
     */
    public function cargar_temariosAction(Request $request) {
        /* 
            Esta función busca los temarios de todas las asignaturas.
            Crea un objeto asignatura que contiene temarios que a su vez contienen secciones vacías
            El objeto asignatura quizá se tenga que serializar.
            Se devolverá el objeto asignatura serializado a la plantilla renderizada.
        */
        return $this->render('Catalogo/catalogo_temarios.html.twig', []);
    }   

   /**
     * @Route("/catalogo/temarios/incluir/{temario}", name="catalogo_incluir_temario")
     */
    public function incluir_temario_pedidoAction(Request $request, $temario) {
        // replace this example code with whatever you need
        echo $temario;
        return $this->render('Catalogo/catalogo_temarios.html.twig', []);
    }

    /**
     * @Route("/catalogo/temarios/{temario}", name="catalogo_secciones")
     */
    public function cargar_secciones_temarioAction(Request $request, $temario) {
        /* 
            Esta función busca las secciones del temario pasado por parámetros.
            Crea un objeto asignatura que contiene temarios que a su vez contienen secciones.
            El objeto asignatura quizá se tenga que serializar.
            Se devolverá el objeto asignatura serializado a la plantilla renderizada.
        */
        echo $temario;
        return $this->render('Catalogo/catalogo_temarios.html.twig', []);
    } 

    /**
     * @Route("/catalogo/temarios/secciones/buscar/{frase}", name="catalogo_buscar_secciones")
     */
    public function cargar_secciones_frase_busquedaAction(Request $request, $frase) {
        /* 
            Esta función busca las secciones cuya descripción coincida en parte con el parámetro dado.
            Crea un objeto asignatura que contiene temarios que a su vez contienen secciones.
            El objeto asignatura quizá se tenga que serializar.
            Se devolverá el objeto asignatura serializado a la plantilla renderizada.
        */
        echo $frase;
        return $this->render('Catalogo/catalogo_temarios.html.twig', []);
    }

    /**
     * @Route("/catalogo/temarios/secciones/incluir/{seccion}", name="catalogo_incluir_seccion")
     */
    public function incluir_seccion_pedidoAction(Request $request, $seccion) {
        // replace this example code with whatever you need
        echo $seccion;
        return $this->render('Catalogo/catalogo_temarios.html.twig', []);
    }  

    /**
     * @Route("/catalogo", name="catalogo_cargar")
     */
    public function cargar_catalogoAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Catalogo/catalogo.html.twig', []);
    }  

    /**
     * @Route("/pedido", name="catalogo_pedido")
     */
    public function cargar_pedidoAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('Catalogo/pedido.html.twig', []);
    }

    /**
     * @Route("/catalogo/pedido/eliminar/{concepto}", name="catalogo_eliminar_concepto")
     */
    public function eliminar_concepto_pedidoAction(Request $request, $concepto) {
        // Tener en cuenta que el concepto es una cookie y NO un objeto en la BBDD
        return $this->render('Catalogo/pedido.html.twig', []);
    }

    /**
     * @Route("/pedido/abonar", name="catalogo_abonar")
     */
    public function abonar_matriculaAction(Request $request) {
        // consultar REDSYS
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
        // replace this example code with whatever you need
        return $this->render('Catalogo/factura.html.twig', []);
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
