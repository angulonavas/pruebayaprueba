<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use SeguridadBundle\Entity\Usuario; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AccesoAulas {

    private $em;
    private $user;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $ts) {
        $this->em = $em;
        $this->user = $ts->getToken()->getUser();
    }

    // Devuelve true si el usuario está matriculado en al menos un temario de la asignatura dada.
    private function hay_temarios($asignatura) {

        $asignatura = $this->em->getRepository(Asignatura::class)->findOneBy(array('titulo' => $asignatura));
        $usuario = $this->user;

        $repositorio = $this->em->getRepository(Matricula_Temarios::class);
        $qb = $repositorio->createQueryBuilder('mt');
        $qb->leftJoin('mt.temario', 't')
           ->where($qb->expr()->andX('t.asignatura = :asignatura', 'mt.usuario = :usuario'))
           ->setParameter('asignatura', $asignatura)
           ->setParameter('usuario', $usuario);

        $matriculas = $qb->getQuery()->getResult();
        $acceso = (count($matriculas)) ? true : false;

        return $acceso;        
    }

    // devuelve true si el usuario está matriculado en dicho temario
    private function existe_temario($asignatura, $temario) {

        // primero se busca la asignatura que coincida con el título de asignatura
        $asignatura = $this->em->getRepository(Asignatura::class)->findOneBy(array(
            'titulo' => $asignatura
        ));
        
        // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
        $temario = $this->em->getRepository(Temario::class)->findOneBy(array(
            'titulo' => $temario,
            'asignatura' => $asignatura
        ));

        // tercero: se busca las posibles matrículas del usuario en el temario encontrado anteriormente
        $matriculas = $this->em->getRepository(Matricula_Temarios::class)->findBy(array(
            'usuario' => $this->user,
            'temario' => $temario
        ));

        $hayTemarios = (count($matriculas)) ? true : false;

        return $hayTemarios;
    }

    // Devuelve true si el usuario está matriculado en al menos una sección del temario de la asignatura dada.
    private function hay_secciones($temario) {

        $temario = $this->em->getRepository(Temario::class)->findOneBy(array('titulo' => $temario));
        $usuario = $this->user;

        $repositorio = $this->em->getRepository(Matricula_Secciones::class);
        $qb = $repositorio->createQueryBuilder('ms');
        $qb->leftJoin('ms.seccion', 's')
           ->where($qb->expr()->andX('s.temario = :temario', 'ms.usuario = :usuario'))
           ->setParameter('temario', $temario)
           ->setParameter('usuario', $usuario);

        $matriculas = $qb->getQuery()->getResult();
        $acceso = (count($matriculas)) ? true : false;

        return $acceso;
    }    

    // devuelve true si el usuario está matriculado en dicha seccion
    private function existe_seccion($asignatura, $temario, $seccion) {

        // primero se busca la asignatura que coincida con el título de asignatura
        $asignatura = $this->em->getRepository(Asignatura::class)->findOneBy(array(
            'titulo' => $asignatura
        ));

        // segundo: se busca el temario de la asignatura anterior que coincida con el título del temario
        $temario = $this->em->getRepository(Temario::class)->findOneBy(array(
            'titulo' => $temario,
            'asignatura' => $asignatura
        ));

        // tercero: se busca la sección del temario anterior cuyo título coincida con el de la sección
        $seccion = $this->em->getRepository(Seccion::class)->findOneBy(array(
            'titulo' => $seccion,
            'temario' => $temario
        ));

        // cuarto: se busca las posibles matrículas del usuario en la sección encontrada anteriormente
        $matriculas = $this->em->getRepository(Matricula_Secciones::class)->findBy(array(
            'usuario' => $this->user,
            'seccion' => $seccion
        ));

        $hayTemarios = (count($matriculas)) ? true : false;

        return $hayTemarios;
    }

    /* 
        hay tres tipos de intento de acceso:
        1.- acceso a los temarios de una asignatura dada: 
            - implica comprobar si el usuario está al menos matricualdo en un temario de dicha asignatura: hay_temarios($asignatura)
        2.- acceso a un temario de una asignatura dada: implica dos acciones: 
            2.1.- comprobar si el usuario está matriculado en dicho temario: existe_temario($temario)
            2.2.- o bien comprobar si el usuario está matriculado en al menos una sección de dicho temario: hay_secciones($temario)
        3.- acceso a una sección del temario de una asignatura dada: 
            - implica comprobar si el usuario está matriculado en dicha sección: existe_seccion($seccion)
    */
    public function acceso($asignatura, $temario = null, $seccion = null) {

        $acceso = false;
        // primer tipo de intento de acceso:
        if (!$temario && !$seccion) $acceso = $this->hay_temarios($asignatura);

        // segundo tipo de intento de acceso:
        elseif (!$seccion) {
            $acceso = $this->existe_temario($asignatura, $temario);
            if (!$acceso) $acceso = $this->hay_secciones($temario);
        
        // tercer tipo de intento de acceso:
        } else $acceso = $this->existe_seccion($asignatura, $temario, $seccion);

        return $acceso;
    }

}