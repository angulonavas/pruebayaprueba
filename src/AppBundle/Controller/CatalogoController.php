<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Concepto;
use AppBundle\Entity\Factura;
use AppBundle\Entity\Matricula_Servicios;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Temario;

use AppBundle\Service\ObjetoUrl;
use AppBundle\Service\PedidoService;
use AppBundle\Service\CatalogoService;

class CatalogoController extends Controller {

    /**
     * @Route("/catalogo/servicios", name="catalogo_servicios")
     */
    public function cargar_serviciosAction(Request $request, CatalogoService $catalogo) {

        $frase = $request->request->get('frase');
        $servicios = $catalogo->desplegar_servicios($frase);

        return $this->render('Catalogo/catalogo_servicios.html.twig', [
            'servicios' => $servicios
        ]);
    }

    /**
     * @Route("/catalogo/servicios/incluir/{servicio}", name="catalogo_incluir_servicio")
     * al incluir un servicio en el pedido lo que se hace realmente es añadir una cookie para el pedido.
     * Esto implica obtener el response y añadir la cookie a la cabecera del response.
     */
    public function incluir_servicio_pedidoAction(Request $request, PedidoService $pedido, CatalogoService $catalogo, $servicio) {
        
        // llamamos al servicio PedidoService para que incluya el $servicio 
        $em = $this->getDoctrine()->getManager();
        $servicio = $em->getRepository(Servicio::class)->find($servicio);
        $pedido->incluir_concepto($servicio);

        return $this->cargar_serviciosAction($request, $catalogo);
    }   

    /**
     * @Route("/catalogo/temarios", name="catalogo_temarios")
     */
    public function cargar_temariosAction(Request $request, CatalogoService $catalogo) {
 
        $asignaturas = $catalogo->desplegar_asignaturas();

        return $this->render('Catalogo/catalogo_temarios.html.twig', [
            'asignaturas' => $asignaturas
        ]);
    }   

   /**
     * @Route("/catalogo/temarios/incluir/{temario}", name="catalogo_incluir_temario")
     * al incluir un servicio en el pedido lo que se hace realmente es añadir una cookie para el pedido.
     * Esto implica obtener el response y añadir la cookie a la cabecera del response.
     */
    public function incluir_temario_pedidoAction(
        Request $request, PedidoService $pedido, CatalogoService $catalogo, $temario) {
        
        $em = $this->getDoctrine()->getManager();
        $temario = $em->getRepository(Temario::class)->find($temario);        
        $pedido->incluir_concepto($temario);

        return $this->cargar_temariosAction($request, $catalogo);
    }

    /**
     * @Route("/catalogo/temarios/{temario_titulo}", name="catalogo_secciones")
     */
    public function cargar_secciones_temarioAction(Request $request, CatalogoService $catalogo, $temario_titulo) {

        $asignaturas = $catalogo->desplegar_asignaturas($temario_titulo);

        return $this->render('Catalogo/catalogo_temarios.html.twig', [
            'asignaturas' => $asignaturas
        ]);
    } 

    /**
     * @Route("/catalogo/temarios/secciones/buscar", name="catalogo_buscar_secciones")
     */
    public function cargar_secciones_frase_busquedaAction(Request $request, CatalogoService $catalogo) {

        $frase = $request->request->get('frase');
        $asignaturas = $catalogo->desplegar_secciones($frase);

        return $this->render('Catalogo/catalogo_temarios.html.twig', [
            'asignaturas' => $asignaturas
        ]);
    }

    /**
     * @Route("/catalogo/temarios/{temario_titulo}/secciones/incluir/{seccion}", name="catalogo_incluir_seccion")
     * al incluir una seccio en el pedido lo que se hace realmente es añadir una cookie para el pedido.
     * Esto implica obtener el response y añadir la cookie a la cabecera del response.     
     */
    public function incluir_seccion_pedidoAction(
        Request $request, PedidoService $pedido, CatalogoService $catalogo, $temario_titulo, $seccion) {
        
        $em = $this->getDoctrine()->getManager();
        $seccion = $em->getRepository(Seccion::class)->find($seccion);        
        $pedido->incluir_concepto($seccion);

        return $this->cargar_secciones_temarioAction($request, $catalogo, $temario_titulo);
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
    public function cargar_pedidoAction(Request $request, PedidoService $pedido) {   
        
        $conceptos = $pedido->get_conceptos();

        return $this->render('Catalogo/detalle_pedido.html.twig', [
            'conceptos' => $conceptos,
        ]);
    }

    /**
     * @Route("/catalogo/pedido/eliminar/{tipo_concepto}/{id_concepto}", name="catalogo_eliminar_concepto")
     */
    public function eliminar_concepto_pedidoAction(Request $request, PedidoService $pedido, $tipo_concepto, $id_concepto) {

        $pedido->eliminar_concepto($tipo_concepto, $id_concepto);
        
        return $this->cargar_pedidoAction($request, $pedido);
    }

    /**
     * @Route("/pedido/revisar", name="catalogo_revisar_pedido")
     */
    public function revisar_pedidoAction(Request $request, PedidoService $pedido) {

        $importe = $request->request->get('importe');
        $conceptos = $pedido->get_conceptos();
        $this->container->getParameter('clave_tpv');
        $token_seguridad = $pedido->get_token_seguridad($importe);

        return $this->render('Catalogo/revisar_pedido.html.twig', [
            'conceptos' => $conceptos,
            'token_seguridad' => $token_seguridad
        ]);
    }

    /**
     * @Route("/pago-realizado-con-exito", name="catalogo_factura")
     */
    public function recepcionar_pagoAction(Request $request, PedidoService $pedido) {

        $token_respuesta = null;

        if ($request->request->get('Ds_SignatureVersion')) {
            $token_respuesta = [
                'version' => $request->request->get("Ds_SignatureVersion"),
                'datos' => $request->request->get("Ds_MerchantParameters"),
                'firma' => $request->request->get("Ds_Signature"),
            ];
        } else if ($request->query->get('Ds_SignatureVersion')) {
            $token_respuesta = [
                'version' => $request->query->get("Ds_SignatureVersion"),
                'datos' => $request->query->get("Ds_MerchantParameters"),
                'firma' => $request->query->get("Ds_Signature"),
            ];
        }

        $exito = $pedido->comprobar_pago($token_respuesta);

        // El pago ha sido satisfactorio
        if ($exito) {

            $fecha = new \DateTime();
            $factura = new Factura();
            $factura->setFecha($fecha);

            // Creando el código de factura
            $em = $this->getDoctrine()->getManager();
            $num_facturas = $em->getRepository(Factura::class)->getNum_facturasHoy() + 1;
            $factura->setCodigo($fecha->format('Y/m/d').'/'.$num_facturas);

            $iva_total = 0;
            $base_imponible = 0;
            
            $conceptos = [];
            $objetos = $pedido->get_conceptos();
            $pedido->eliminar_conceptos();
            
            foreach ($objetos as $objeto) {
                $precio_unitario = $objeto->getPrecio();
                $iva = $precio_unitario * ($objeto->getIva()/100);

                // Creamos el concepto
                $concepto = new Concepto();
                $concepto->setDescripcion($objeto->getTitulo());
                $concepto->setPrecio($precio_unitario - $iva);
                $concepto->setIva($objeto->getIva());
                $conceptos[] = $concepto;

                // Calculando los totales
                $iva_total += $iva;
                $base_imponible += $concepto->getPrecio();
            }

            // Incluyendo iva total e importe total a la factura
            $factura->setIva($iva_total);
            $factura->setTotal($base_imponible + $iva_total);
            
            foreach ($conceptos as $concepto) {
                $concepto->setFactura($factura);
                $em->persist($concepto);
            }

            $factura->setConceptos($conceptos);
            $em->persist($factura);
            $em->flush();

            return $this->render('Catalogo/factura.html.twig', [
                'factura' => $factura,
            ]);
        
        } else {
            // renderizar error: no se ha podido gestionar el pago
            return $this->render('SeguridadBundle/acceso_denegado.html.twig', []);
        }
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
