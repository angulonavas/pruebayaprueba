<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use AppBundle\Entity\Matricula_Servicios;

use AppBundle\Lib\RedsysAPI;

use SeguridadBundle\Entity\Usuario; 
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PedidoService {

    private $em;
    private $user;
    private $requestStack;
    private $urlGenerator;
    private $container;

    public function __construct(
        EntityManagerInterface $em, 
        TokenStorageInterface $ts, 
        RequestStack $requestStack, 
        UrlGeneratorInterface $urlGenerator,
        ContainerInterface $container) {
        $this->em = $em;
        $this->user = $ts->getToken()->getUser();
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
        $this->container = $container;
    }

    // Función que crea el token de seguridad
    private function crear_token_seguridad($importe) {

        /*
         *   Tarjeta de ejemplo:
         *       num targeta: 4548812049400004
         *       fecha caducidad: 12/20
         *       cvv: 285
         */

        $miObj = new RedsysAPI();
            
        // Valores de entrada
        $fuc = "999008881";
        $terminal = "871";
        $moneda = "978";
        $trans = "0";
        $url = "";
        $urlOKKO = $this->urlGenerator->generate('catalogo_factura', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $id = time();
        $amount = $importe * 100;
        
        $request = $this->requestStack->getCurrentRequest();
        
        // Se Rellenan los campos
        $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
        $miObj->setParameter("DS_MERCHANT_ORDER",strval($id));
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
        $miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
        $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
        $miObj->setParameter("DS_MERCHANT_URLOK",$urlOKKO);     
        $miObj->setParameter("DS_MERCHANT_URLKO",$urlOKKO);

        //Datos de configuración
        $version="HMAC_SHA256_V1";
        $kc = $this->container->getParameter('clave_tpv');
        
        // Se generan los parámetros de la petición
        $request = "";
        $params = $miObj->createMerchantParameters();
        $signature = $miObj->createMerchantSignature($kc);

        $token = [
            'version' => $version, 
            'parametros' => $params, 
            'firma' => $signature 
        ];

        return $token;
    }

    // Obtiene el token de respuesta al pago realizado por el usuario
    private function comprobar_token_respuesta($token_respuesta) {

        $miObj = new RedsysAPI();

        $decodec = $miObj->decodeMerchantParameters($token_respuesta['datos']);
        $kc = $this->container->getParameter('clave_tpv');
        $firma = $miObj->createMerchantSignatureNotif($kc,$token_respuesta['datos']);

        $exito = ($firma === $token_respuesta['firma']) ? true : false;

        return $exito;
    }

    // Obtiene el objeto del tipo correspondiente 
    private function get_concepto($tipo, $id) {

        $concepto = null;
        switch ($tipo) {
            case 'Servicio': $concepto = $this->em->getRepository(Servicio::class)->find($id); break;
            case 'Temario': $concepto = $this->em->getRepository(Temario::class)->find($id); break;
            case 'Seccion': $concepto = $this->em->getRepository(Seccion::class)->find($id); break;
        }

        return $concepto;
    }



    // Obtiene el token de seguridad del pedido
    public function get_token_seguridad($importe) {
        return $this->crear_token_seguridad($importe);
    }

    // Comprueba el token de respuesta
    public function comprobar_pago($token_respuesta) {
        return $this->comprobar_token_respuesta($token_respuesta);
    }

    // Devuelve el número de conceptos creados en las variables de sesión
    public function get_num_conceptos() {

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();        
        $conceptos = $session->get('conceptos');
        
        return count($conceptos);
    }

    // inserta un nuevo concepto en el pedido del usuario
    public function incluir_concepto($objeto) {

        $clase = explode('\\', get_class($objeto));
        $clase = $clase[count($clase)-1];

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();        

        $conceptos = $session->get('conceptos');
        $conceptos[$clase.'_'.$objeto->getId()] = '1';
        $session->set('conceptos', $conceptos);
    }

    // obtiene todos los conceptos del pedido almacenados en variables de sesión
    public function get_conceptos() {

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();        

        $conceptos = [];
        foreach ($session->get('conceptos') as $key => $vector) { 
            $concepto = explode('_', $key);
            $conceptos[] = $this->get_concepto($concepto[0], $concepto[1]);
        }

        return $conceptos;
    }

    // elimina un concpeto de las variables de sesión en base al tipo de concepto y su identificador
    public function eliminar_concepto($tipo_concepto, $id_concepto) {

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $conceptos = $session->get('conceptos'); // en tokens tengo el vector
        if (isset($conceptos[$tipo_concepto.'_'.$id_concepto])) { 
            unset($conceptos[$tipo_concepto.'_'.$id_concepto]); // elimino el elemnto del vector
            $session->set('conceptos', $conceptos); // vuelvo a guardar el vector
        }
    }

    // eliminar todos los conceptos
    public function eliminar_conceptos() {

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->set('conceptos', []); // vuelvo a guardar el vector
    }
}