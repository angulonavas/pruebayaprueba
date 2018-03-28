<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consulta
 *
 * @ORM\Table(name="consulta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultaRepository")
 */
class Consulta
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=16)
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="SeguridadBundle\Entity\Usuario", inversedBy="consultas")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    private $usuario; 

    /**
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="consultas")
     * @ORM\JoinColumn(name="id_seccion", referencedColumnName="id")
     */
    private $seccion;

    /**
     * @ORM\OneToOne(targetEntity="Respuesta", mappedBy="consulta")
     */
    private $respuesta;    

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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Consulta
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Consulta
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Consulta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /** 
     * Set usuario
     * 
     * @param Usuario $usuario
     * 
     * @return Consulta
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

    /** 
     * Set seccion
     * 
     * @param Seccion $seccion
     * 
     * @return Consulta
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
     * Set respuesta
     * 
     * @param Respuesta $respuesta
     * 
     * @return Consulta
     */ 
    public function setRespuesta($respuesta) 
    { 
        $this->respuesta = $respuesta; 

        return $this; 
    } 

    /** 
     * Get respuesta 
     * 
     * @return Respuesta 
     */ 
    public function getRespuesta() 
    { 
        return $this->respuesta; 
    }    
}

