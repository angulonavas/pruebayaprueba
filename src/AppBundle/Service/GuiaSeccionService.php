<?php

namespace AppBundle\Service;

use AppBundle\Entity\Seccion;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/*
 *   si $guias['id_temario'] no existe -> el usuario no puede elegir entre guiado y no guiado
 *   si $guias['id_temario'] = 0 -> el estudio es guiable pero está habilitada la opción "No guiado"
 *   si $guias['id_temario'] = id_seccion -> el estudio es guiable y está habilitada la opción "guiado"
 */
class GuiaSeccionService {

    private $em;
    private $requestStack;
    private $guias;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        
        $this->guias = $session->get('guias');
    }

    // crea una guia para el temario en la sección dada, si no existe. el temario se extrae de la sección
    // para ello se crea una variable de sesión dentro de guias con key = id_temario y valor = id_seccion
    public function setGuia($seccion) {
        $this->guias[$seccion->getTemario()->getId()] = [
            'guiado' => true,
            'seccion' => $seccion->getId()
        ];

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->set('guias', $this->guias);
    }

    // devuelve la sección que marca la guia para ese temario, si existe.
    // si no existe devuelve null
    public function getGuia($temario) {
        $guia = null;
        if (isset($this->guias[$temario->getId()])) {

            // recuperamos la guía pero en vez de devolver el id de sección devolveremos directamente la sección
            $guia = $this->guias[$temario->getId()];
            $guia['seccion'] = $this->em->getRepository(Seccion::class)->buscar($guia['seccion']); 
        }

        return $guia;
    }

    // si la guia indica que el temario'está guiado, lo dejará en no guiado y al revés
    public function toggleGuiado($temario) {
        if ($this->guias[$temario->getId()]) {
            $guia = $this->guias[$temario->getId()];
            if ($guia['guiado']) $guia['guiado'] = false;
            else $guia['guiado'] = true;
            $this->guias[$temario->getId()] = $guia;
            
            $request = $this->requestStack->getCurrentRequest();
            $session = $request->getSession();
            $session->set('guias', $this->guias);
        }
    }

    // comprueba si existe guia para el temario
    public function existeGuia($temario) {
        return (isset($this->guias[$temario->getId()])) ? true : false;
    }
}