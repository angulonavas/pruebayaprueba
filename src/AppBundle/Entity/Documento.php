<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 * @UniqueEntity(
 *     fields="fichero",
 *     message="Lo sentimos, ya existe un fichero con ese nombre" 
 * ) 
 */
class Documento
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
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="No has adjuntado fichero")
     * @Assert\File(
     *      maxSize = "2M",
     *      maxSizeMessage = "Lo sentimos, el fichero no puede ser mayor de 2MB",
     *      mimeTypes={ "application/pdf" },
     *      mimeTypesMessage = "El fichero debe ser de tipo PDF"
     * )
     */
    private $fichero;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=32)
     * @Assert\Length(
     *      min = 4,
     *      max = 32,
     *      minMessage = "Descripción debe ser mayor de {{ limit }} caracteres",
     *      maxMessage = "La descripción sólo puede tener {{ limit }} caracteres"
     * )
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="publicado", type="boolean", options={"default" : "1"})
     */
    private $publicado;

    /**
     * @var integer
     *
     * @ORM\Column(name="prioridad", type="integer", options={"default" : "2"})
     */
    private $prioridad;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=16)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="documentos")
     * @ORM\JoinColumn(name="id_asignatura", referencedColumnName="id")
     */
    private $asignatura;

    /**
     * @ORM\ManyToOne(targetEntity="SeguridadBundle\Entity\Usuario", inversedBy="documentos")
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
     * Set fichero
     *
     * @param string $fichero
     *
     * @return Documento
     */
    public function setFichero($fichero)
    {
        $this->fichero = $fichero;

        return $this;
    }

    /**
     * Get fichero
     *
     * @return string
     */
    public function getFichero()
    {
        return $this->fichero;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Documento
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
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Documento
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;

        return $this;
    }

    /**
     * Get publicado
     *
     * @return bool
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     *
     * @return Documento
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Documento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

   /** 
     * Set asignatura
     * 
     * @param Asignatura $asignatura
     * 
     * @return Documento
     */ 
    public function setAsignatura($asignatura) 
    { 
        $this->asignatura = $asignatura; 

        return $this; 
    } 

    /** 
     * Get asignatura 
     * 
     * @return Asignatura 
     */ 
    public function getAsignatura() 
    { 
        return $this->asignatura; 
    }     

    /** 
     * Set usuario
     * 
     * @param Usuario $usuario
     * 
     * @return Documento
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

