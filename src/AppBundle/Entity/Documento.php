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
 *     fields="attachment",
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
     * @ORM\Column(name="nombre_fichero", type="string", length=32, unique=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 32,
     *      minMessage = "Nombre de fichero incorrecto",
     *      maxMessage = "El nombre del fichero sólo puede tener {{ limit }} caracteres"
     * )
     */
    private $nombreFichero;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=64)
     * @Assert\Length(
     *      min = 4,
     *      max = 64,
     *      minMessage = "Descripción debe ser mayor de {{ limit }} caracteres",
     *      maxMessage = "La descripción sólo puede tener {{ limit }} caracteres"
     * )
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="corrupto", type="boolean")
     */
    private $corrupto;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", length=8)
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

    protected $attachment;



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
     * Set nombreFichero
     *
     * @param string $nombreFichero
     *
     * @return Documento
     */
    public function setNombreFichero($nombreFichero)
    {
        $this->nombreFichero = $nombreFichero;

        return $this;
    }

    /**
     * Get nombreFichero
     *
     * @return string
     */
    public function getNombreFichero()
    {
        return $this->nombreFichero;
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
     * Set corrupto
     *
     * @param boolean $corrupto
     *
     * @return Documento
     */
    public function setCorrupto($corrupto)
    {
        $this->corrupto = $corrupto;

        return $this;
    }

    /**
     * Get corrupto
     *
     * @return bool
     */
    public function getCorrupto()
    {
        return $this->corrupto;
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

    // Get el fichero en sí. Necesario para el formulario
    public function getAttachment() {
        return $this->attachment;
    }    

    public function setAttachment($attachment) {
        $this->attachment = $attachment;
        return $this;
    }
}

