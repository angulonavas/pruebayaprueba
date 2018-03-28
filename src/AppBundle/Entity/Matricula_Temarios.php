<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matricula_Temarios
 *
 * @ORM\Table(name="matricula__temarios")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Matricula_TemariosRepository")
 */
class Matricula_Temarios
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
     * @ORM\ManyToOne(targetEntity="Temario", inversedBy="matriculas_temarios")
     * @ORM\JoinColumn(name="id_temario", referencedColumnName="id")
     */
    private $temario;


    /**
     * @ORM\ManyToOne(targetEntity="SeguridadBundle\Entity\Usuario", inversedBy="matriculas_temarios")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    private $usuario;    


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
     * @return Matricula_Temarios
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
     * Set temario
     * 
     * @param Temario $temario
     * 
     * @return Matricula_Temarios
     */ 
    public function setTemario($temario) 
    { 
        $this->temario = $temario; 

        return $this; 
    } 

    /** 
     * Get temario 
     * 
     * @return Temario 
     */ 
    public function getTemario() 
    { 
        return $this->temario; 
    }    

    /** 
     * Set usuario
     * 
     * @param Usuario $usuario
     * 
     * @return Matricula_Temarios
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

