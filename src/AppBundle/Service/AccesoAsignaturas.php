<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use SeguridadBundle\Entity\Usuario; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AccesoAsignaturas {

    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // Devuelve lista de las asignaturas
    public function get_asignaturas() {
        $asignaturas = $this->em->getRepository(Asignatura::class)->findAll();
        return $asignaturas;
    }

}