<?php

namespace SeguridadBundle\Controller;

use SeguridadBundle\Form\RecuperacionType;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioAdminController extends Controller {

	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder) {
    	$this->encoder = $encoder;
    }	

    //public function __construct($code, $class, $baseControllerName, UserPasswordEncoderInterface $encoder) {
        //parent::__construct($code, $class, $baseControllerName);
      //  $this->encoder = $encoder;
    //}	
					
	public function batchActionDesactivar(ProxyQueryInterface $selectedModelQuery, Request $request = null) {

		$modelManager = $this->admin->getModelManager();
    	$selectedModels = $selectedModelQuery->execute();

        foreach ($selectedModels as $selectedModel) {
        	$selectedModel->setIsActive(false);
        	$modelManager->update($selectedModel);
        }

		$this->addFlash('sonata_flash_success', 'Los usuarios han quedado desactivados');

		return new RedirectResponse($this->admin->generateUrl('list'));
	}

	public function cambiarClaveAction(Request $request) {
		
		$usuario = $this->admin->getSubject();

        $form = $this->createForm(RecuperacionType::class, $usuario);
        $form->handleRequest($request);		

        $realizado = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $form->getData();

            // Codificando el password
            $encoded = $this->encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($encoded);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usuario);
            $manager->flush();

            $realizado = 'La clave ha cambiado con éxito';
        }

        return $this->render('@Seguridad/Admin/clave.html.twig', [
            'id' => $usuario->getId(),
            'action' => 'clave',
            'object' => $usuario,
            'form' => $form->createView(),
            'realizado' => $realizado
        ]);
	}		

}
