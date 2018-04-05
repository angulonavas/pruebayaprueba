<?php

namespace AppBundle\Service;

use SeguridadBundle\Entity\Usuario; 
use Doctrine\ORM\EntityManagerInterface;

class AlumnadoService {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getNum_alumnos() {

        //$em = $this->getDoctrine()->getManager();
        $repositorio = $this->em->getRepository(Usuario::class);

        $qb = $repositorio->createQueryBuilder('u');
        $qb->select('count(u.id)');
        $qb->where($qb->expr()->eq('u.isActive', 'true'));

        $query = $qb->getQuery();
        $count = $qb->getQuery()->getSingleScalarResult();        

        return $count;
    }
}