<?php

namespace AppBundle\Repository;

/**
 * DocumentoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentoRepository extends \Doctrine\ORM\EntityRepository {

	// devuelve todos los documentos activos de la asignatura dada
    public function buscarTodos($asignatura) {
        
        $qb = $this->createQueryBuilder('d');
        $qb->where($qb->expr()->andX(
        		$qb->expr()->eq('d.publicado', 'true'),
        		$qb->expr()->eq('d.asignatura', ':asignatura')
        	)
    	)
		->setParameter('asignatura', $asignatura)
        ->addOrderBy('d.prioridad', 'ASC')
        ->addOrderBy('d.descripcion', 'ASC');

        $documentos = $qb->getQuery()->getResult(); 

        return $documentos;
    }	
}
