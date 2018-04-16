<?php

namespace AppBundle\Repository;

/**
 * FacturaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacturaRepository extends \Doctrine\ORM\EntityRepository {

	public function getNum_facturasHoy() {

		$hoy = new \DateTime();
		$hoy->setTime(0,0,0);

		$manyana = new \DateTime();
		$manyana->add(new \DateInterval('P1D'));

        $qb = $this->createQueryBuilder('f'); 
        $qb->select('count(f.id)') 
           ->where($qb->expr()->andX('f.fecha >= :hoy', 'f.fecha <=:manyana')) 
           ->setParameter('hoy', $hoy) 
           ->setParameter('manyana', $manyana); 

		$count = $qb->getQuery()->getSingleScalarResult(); 
		return $count;
	}
}
