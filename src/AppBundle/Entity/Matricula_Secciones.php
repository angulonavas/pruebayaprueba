<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matricula_Secciones
 *
 * @ORM\Table(name="matricula__secciones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Matricula_SeccionesRepository")
 */
class Matricula_Secciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="SeguridadBundle\Entity\Usuario", inversedBy="matriculas_servicios")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    private $usuario; 

    /**
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="matriculas_servicios")
     * @ORM\JoinColumn(name="id_seccion", referencedColumnName="id")
     */
    private $seccion;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Matricula_Secciones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /** 
     * Set seccion
     * 
     * @param Seccion $seccion
     * 
     * @return Matricula_Secciones
     */ 
    public function setSeccion($seccion) 
    { 
        $this->seccion = $seccion; 

        return $this; 
    } 

    /** 
     * Get seccion 
     * 
     * @return Seccion 
     */ 
    public function getSeccion() 
    { 
        return $this->seccion; 
    }    

    /**
     * Set usuario
     *
     * @param Usuario $usuario
     *
     * @return Matricula_Secciones
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }     
}

