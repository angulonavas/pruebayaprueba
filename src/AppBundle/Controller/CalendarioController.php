<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use AppBundle\Entity\Servicio;

class CalendarioController extends Controller {

	private function crearVector_servicio($servicio) {

		$vecServicio = [
			'titulo' => $servicio->getTitulo(),
			'fecha_ini' => $servicio->getFechaIni()->format('Y-m-d H:i:s'),
			'fecha_fin' => $servicio->getFechaFin()->format('Y-m-d H:i:s'),
			'descripcion' => $servicio->getDescripcion(),
			'precio' => $servicio->getPrecio().' €'
		];

		return $vecServicio;
	}

    /**
     * @Route("/calendario", name="calendario_cargar")
     */
    public function cargarAction(Request $request) {

    	// buscando el servicio
		$em = $this->getDoctrine()->getManager();
        $servicios = $em->getRepository(Servicio::class)->findAll();

        $vecServicios = [];
        foreach ($servicios as $i => $valor) {
        	$vecServicios[] = $this->crearVector_servicio($valor);
        }
        

        // definiendo el serializer
	   	$encoders = array(new JsonEncoder());
	   	$normalizers = array(new ObjectNormalizer());
		$serializer = new Serializer($normalizers, $encoders);

		// codificando el vector de Servicios
        $jsonContent = $serializer->encode($vecServicios, 'json');

        return $this->render('Contenido/calendario.html.twig', [
        	'eventos' => $jsonContent
        ]);
    }
}
