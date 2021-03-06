<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Temario
 *
 * @ORM\Table(name="temario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemarioRepository")
 */
class Temario
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
     * @ORM\Column(name="titulo", type="string", length=64)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512)
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float")
     */
    private $precio;

    /**
     * @var float
     *
     * @ORM\Column(name="iva", type="float")
     */
    private $iva = 11;

    /**
     * @var bool
     *
     * @ORM\Column(name="publicado", type="boolean")
     */
    private $publicado;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer", options={"default" : 0})
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="temarios")
     * @ORM\JoinColumn(name="id_asignatura", referencedColumnName="id")
     */
    private $asignatura;

   /**
     * @ORM\OneToMany(targetEntity="Matricula_Temarios", mappedBy="temario")
     */
    private $matriculas_temarios;

   /**
     * @ORM\OneToMany(targetEntity="Seccion", mappedBy="temario")
     */
    private $secciones;

    // si el usuario actual está o no matriculado de la presente temario
    private $matriculado;



    public function __construct()
    {
        $this->matriculas_temarios = new ArrayCollection();
    }

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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Temario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Temario
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
     * Set precio
     *
     * @param float $precio
     *
     * @return Temario
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Set iva
     *
     * @param float $iva
     *
     * @return Temario
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return float
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Temario
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Temario
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return int
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /** 
     * Set asignatura
     * 
     * @param Asignatura $asignatura
     * 
     * @return Temario
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
     * Get matriculado
     * @return booleano
     */
    public function getMatriculado() {
        return $this->matriculado;
    }

    /**
     * Set matriculado
     * @param boolean $matriculado
     * @return boolean
     */
    public function setMatriculado($matriculado) {
        $this->matriculado = $matriculado;
        return $this;
    }

    // devuelve las secciones asignadas
    public function getSecciones() {
        return $this->secciones;
    }    

    // asigna las secciones al temario
    public function setSecciones($secciones) {
        $this->secciones = $secciones;
    }

    public function liberaSecciones() {
        $this->secciones = null;
    }

    public function setSeccion($seccion) {
        $this->secciones[] = $seccion;   
    }
}

