<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use AppBundle\Entity\Matricula_Servicios;

use SeguridadBundle\Entity\Usuario; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CatalogoService {

    private $em;
    private $user;
    private $autorizacion;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $ts, AuthorizationCheckerInterface $autorizacion) {
        $this->em = $em;
        $this->user = $ts->getToken()->getUser();
        $this->autorizacion = $autorizacion;
    }

    // Devuelve true si el usuario está matriculado en al menos una sección de un temario de la asignatura dada.
    public function desplegar_asignaturas($temario_titulo = null) {

        $asignaturas = $this->em->getRepository(Asignatura::class)->buscarTodo();

        foreach ($asignaturas as $asignatura) {
            $temarios = $this->em->getRepository(Temario::class)->buscarTodos($asignatura);
            $asignatura->setTemarios($temarios);

            foreach ($asignatura->getTemarios() as $temario) {
                $secciones = $this->em->getRepository(Seccion::class)->buscarTodos($temario);
                $temario->setSecciones($secciones);

                $matriculado = ($this->autorizacion->isGranted('IS_AUTHENTICATED_FULLY')) ?
                    $this->em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->user) :
                    false;
                $temario->setMatriculado($matriculado);
                if ($temario->getTitulo() != $temario_titulo) $temario->liberaSecciones();
                else {
                    foreach ($temario->getSecciones() as $seccion) {
                        $matriculado = ($this->autorizacion->isGranted('IS_AUTHENTICATED_FULLY')) ?
                            $this->em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->user) :
                            false;
                        $seccion->setMatriculado($matriculado);
                    }
                }
            }
        }

        return $asignaturas;
    }

    // Devuelve true si el usuario está matriculado en al menos un temario de la asignatura dada.
    public function desplegar_servicios($frase) {

        $servicios = ($frase) ? 
            $this->em->getRepository(Servicio::class)->buscarFrase($frase) : 
            $this->em->getRepository(Servicio::class)->buscarTodo();

        // Se obtiene el estado de matriculación para cada servicio
        foreach ($servicios as $servicio) {
            $matriculado = ($this->autorizacion->isGranted('IS_AUTHENTICATED_FULLY')) ?
                $this->em->getRepository(Matricula_Servicios::class)->isMatriculado($servicio, $this->user) :
                false;
            $servicio->setMatriculado($matriculado);
        }

        return $servicios;
    }

    // devuelve true si el usuario está matriculado en dicho temario
    public function desplegar_secciones($frase) {

        $secciones = $this->em->getRepository(Seccion::class)->buscar($frase);
        $asignaturas = $this->em->getRepository(Asignatura::class)->findAll();

        // Liberamos las secciones de cada temario
        foreach ($asignaturas as $asignatura) {
            foreach ($asignatura->getTemarios() as $temario) {
                $matriculado = ($this->autorizacion->isGranted('IS_AUTHENTICATED_FULLY')) ?
                    $this->em->getRepository(Matricula_Temarios::class)->isMatriculado($temario, $this->user) :
                    false;
                $temario->setMatriculado($matriculado);                
                $temario->liberaSecciones();
            }
        }

        // Recorreremos cada sección para asignar cada una de ellas a su correspondiente temario
        foreach ($secciones as $seccion) {            
            
            // Se comprueba si se está matriculado
            $matriculado = ($this->autorizacion->isGranted('IS_AUTHENTICATED_FULLY')) ?
                $this->em->getRepository(Matricula_Secciones::class)->isMatriculado($seccion, $this->user) :
                false;
            $seccion->setMatriculado($matriculado);

            // recorremos cada temario para asignar la sección al temario correspondiente
            foreach ($asignaturas as $asignatura) {
                foreach ($asignatura->getTemarios() as $temario) {
                    if ($seccion->getTemario() == $temario) {
                        $temario->setSeccion($seccion);
                        break 2;
                    }
                }
            }
        }

        return $asignaturas;
    }

}