<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Servicio;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Config\Definition\Exception\Exception;

// Este servicio sirve para obtener un objeto único en base a los parámetros recibidos
class ObjetoUrl {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // Devuelve la asignatura encontrada
    public function buscar_asignatura($asignatura) {
        $asignatura = $this->em->getRepository(Asignatura::class)->findOneBy([
            'titulo' => $asignatura,
            'publicado' => true
        ]);

        return $asignatura;
    }

    // devuelve el temario encontrado
    public function buscar_temario($asignatura, $temario) {

        try {
            // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
            if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("asignatura no disponible", 1);

            // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
            $temario = $this->em->getRepository(Temario::class)->findOneBy(array(
                'titulo' => $temario,
                'asignatura' => $asignatura,
                'publicado' => true
            ));
            if (!$temario) throw new Exception("temario no disponible", 1);

            return $temario;
        } catch (Exception $e) { return null; }        
    }

    // Devuelve true si el usuario está matriculado en al menos una sección del temario de la asignatura dada.
    public function buscar_seccion($asignatura, $temario, $seccion) {

        try{
            // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
            if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("asignatura no disponible", 1);

            // segundo: si $temario no es un objeto primero se busca el temario que coincida con el título de temario
            if (!is_object($temario)) $temario = $this->buscar_temario($asignatura, $temario);
            if (!$temario) throw new Exception("temario no disponible", 1);

            // tercero: se busca la sección del temario de la asignatura
            $seccion = $this->em->getRepository(Seccion::class)->findOneBy(array(
                'titulo' => $seccion,
                'temario' => $temario,
                'publicado' => true
            ));
            if (!$seccion) throw new Exception("sección no disponible", 1);

            return $seccion;
        } catch (Exception $e) { return null; }        
    }    

    // devuelve la categoría encontrada
    public function buscar_categoria($asignatura, $categoria) {

        try {
            // si $asignatura no es un objeto primero se busca la asignatura que coincida con el título de asignatura
            if (!is_object($asignatura)) $asignatura = $this->buscar_asignatura($asignatura);
            if (!$asignatura) throw new Exception("asignatura no disponible", 1);

            // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
            $categoria = $this->em->getRepository(Categoria::class)->findOneBy(array(
                'descripcion' => $categoria,
                'asignatura' => $asignatura->getId()
            ));
            if (!$categoria) throw new Exception("categoria no disponible", 1);

            return $categoria;
        } catch (Exception $e) { return null; }
    }

    // devuelve el servicio encontrado
    public function buscar_servicio($servicio) {

        $servicio = $this->em->getRepository(Servicio::class)->findOneBy([
            'titulo' => $servicio,
            'publicado' => true
        ]);

        return $servicio;
    }    

}