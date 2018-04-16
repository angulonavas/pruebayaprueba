<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Servicio;
use Doctrine\ORM\EntityManagerInterface;

// Este servicio sirve para obtener un objeto único en base a los parámetros recibidos
class ObjetoUrl {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // Devuelve la asignatura encontrada
    public function buscar_asignatura($asignatura) {
        return $this->em->getRepository(Asignatura::class)->findOneByTitulo($asignatura);
    }

    // devuelve el temario encontrado
    public function buscar_temario($asignatura, $temario) {

        // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
        if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);
        
        // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
        $temario = $this->em->getRepository(Temario::class)->findOneBy(array(
            'titulo' => $temario,
            'asignatura' => $asignatura
        ));

        return $temario;
    }

    // Devuelve true si el usuario está matriculado en al menos una sección del temario de la asignatura dada.
    public function buscar_seccion($asignatura, $temario, $seccion) {

        // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
        if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);

        // segundo: si $temario no es un objeto primero se busca el temario que coincida con el título de temario
        if (!is_object($temario)) $temario = $this->buscar_temario($asignatura, $temario);

        // tercero: se busca la sección del temario de la asignatura
        $seccion = $this->em->getRepository(Seccion::class)->findOneBy(array(
            'titulo' => $seccion,
            'temario' => $temario
        ));

        return $seccion;
    }    

    // devuelve el temario encontrado
    public function buscar_categoria($asignatura, $categoria) {

        // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
        if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);
        
        // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
        $categoria = $this->em->getRepository(Categoria::class)->findOneBy(array(
            'descripcion' => $categoria,
            'asignatura' => $asignatura->getId()
        ));

        return $categoria;
    }

    // devuelve el servicio encontrado
    public function buscar_servicio($servicio) {

        return $this->em->getRepository(Servicio::class)->findOneByTitulo($servicio);
    }    

}