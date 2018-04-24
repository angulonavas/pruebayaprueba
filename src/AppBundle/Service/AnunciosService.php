<?php

namespace AppBundle\Service;

use AppBundle\Entity\Anuncio;

use Doctrine\ORM\EntityManagerInterface;

class AnunciosService {

    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // Devuelve lista de las asignaturas
    public function get_anuncios() {
        $anuncios = $this->em->getRepository(Anuncio::class)->findAll();
        return $anuncios;
    }

}