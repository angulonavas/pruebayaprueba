<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Seccion
 *
 * @ORM\Table(name="seccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeccionRepository")
 */
class Seccion
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
     * @var int
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;

    /**
     * @var bool
     *
     * @ORM\Column(name="teorica", type="boolean")
     */
    private $teorica;

    /**
     * @var bool
     *
     * @ORM\Column(name="publicado", type="boolean")
     */
    private $publicado;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float")
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="plantilla", type="string", length=32, unique=true)
     */
    private $plantilla;

    /**
     * @ORM\ManyToOne(targetEntity="Temario", inversedBy="secciones")
     * @ORM\JoinColumn(name="id_temario", referencedColumnName="id")
     */
    private $temario;

    /**
     * @ORM\OneToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="id_anterior", referencedColumnName="id")
     */
    private $anterior;

    /**
     * @ORM\OneToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="id_posterior", referencedColumnName="id")
     */
    private $posterior;

   /**
     * @ORM\OneToMany(targetEntity="Matricula_Secciones", mappedBy="seccion")
     */
    private $matriculas_secciones;

   /**
     * @ORM\OneToMany(targetEntity="Pregunta_Examen", mappedBy="seccion")
     */
    private $preguntas_examen;

    public function __construct()
    {
        $this->matriculas_secciones = new ArrayCollection();
        $this->preguntas_examen = new ArrayCollection();
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Seccion
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Seccion
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
     * @return Seccion
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
     * Set teorica
     *
     * @param boolean $teorica
     *
     * @return Seccion
     */
    public function setTeorica($teorica)
    {
        $this->teorica = $teorica;

        return $this;
    }

    /**
     * Get teorica
     *
     * @return bool
     */
    public function getTeorica()
    {
        return $this->teorica;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Seccion
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
     * Set precio
     *
     * @param float $precio
     *
     * @return Seccion
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
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
     * Set plantilla
     *
     * @param string $plantilla
     *
     * @return Seccion
     */
    public function setPlantilla($plantilla)
    {
        $this->plantilla = $plantilla;

        return $this;
    }

    /**
     * Get plantilla
     *
     * @return string
     */
    public function getPlantilla()
    {
        return $this->plantilla;
    }

    /** 
     * Set temario
     * 
     * @param Temario $temario
     * 
     * @return Seccion
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
     * Set anterior
     * 
     * @param Seccion $anterior
     * 
     * @return Seccion
     */ 
    public function setAnterior($anterior) 
    { 
        $this->anterior = $anterior; 

        return $this; 
    } 

    /** 
     * Get anterior 
     * 
     * @return Seccion 
     */ 
    public function getAnterior() 
    { 
        return $this->anterior; 
    } 

   /** 
     * Set posterior
     * 
     * @param Seccion $posterior
     * 
     * @return Seccion
     */ 
    public function setPosterior($posterior) 
    { 
        $this->posterior = $posterior; 

        return $this; 
    } 

    /** 
     * Get posterior 
     * 
     * @return Seccion 
     */ 
    public function getPosterior() 
    { 
        return $this->posterior; 
    } 

}

