<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 *
 * @ORM\Table(name="respuesta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RespuestaRepository")
 */
class Respuesta
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
     * @ORM\Column(name="descricion", type="string", length=512)
     */
    private $descricion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="SeguridadBundle\Entity\Usuario", inversedBy="respuestas")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    private $usuario; 

   /**
     * @ORM\OneToOne(targetEntity="Consulta", inversedBy="respuesta")
     * @ORM\JoinColumn(name="id_consulta", referencedColumnName="id")
     */
    private $consulta;


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
     * Set descricion
     *
     * @param string $descricion
     *
     * @return Respuesta
     */
    public function setDescricion($descricion)
    {
        $this->descricion = $descricion;

        return $this;
    }

    /**
     * Get descricion
     *
     * @return string
     */
    public function getDescricion()
    {
        return $this->descricion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Respuesta
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
     * Set usuario
     * 
     * @param Usuario $usuario
     * 
     * @return Respuesta
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
     * Set consulta
     * 
     * @param Consulta $consulta
     * 
     * @return Respuesta
     */ 
    public function setConsulta($consulta) 
    { 
        $this->consulta = $consulta; 

        return $this; 
    } 

    /** 
     * Get consulta 
     * 
     * @return Consulta 
     */ 
    public function getConsulta() 
    { 
        return $this->consulta; 
    }
}

