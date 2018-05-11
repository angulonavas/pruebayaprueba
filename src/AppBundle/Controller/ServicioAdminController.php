<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ServicioAdminController extends Controller {

	public function verUsuariosAction() {
		$servicio = $this->admin->getSubject();

		//return new RedirectResponse($this->generateUrl('admin_app_factura_list'));
		return new RedirectResponse($this->generateUrl('usuarios_servicio_list', [
			'id' => $servicio->getId()
		]));
	}
}
