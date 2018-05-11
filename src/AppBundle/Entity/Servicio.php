<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @ORM\Column(name="titulo", type="string", length=32)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ini", type="datetime")
     */
    private $fechaIni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime")
     */
    private $fechaFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="prioridad", type="integer", options={"default" : 1})
     */
    private $prioridad;

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
     * @ORM\OneToMany(targetEntity="Matricula_Servicios", mappedBy="servicio")
     */
    private $matriculas_servicios;

    // No pertenece a la BBDD. Sirve para comprobar si el usuario está o no matriculado de este servicio
    private $matriculado;



    public function __construct()
    {
        $this->matriculas_servicios = new ArrayCollection();
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
     * @return Servicio
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
     * @return Servicio
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
     * Set fechaIni
     *
     * @param \DateTime $fechaIni
     *
     * @return Servicio
     */
    public function setFechaIni($fechaIni)
    {
        $this->fechaIni = $fechaIni;

        return $this;
    }

    /**
     * Get fechaIni
     *
     * @return \DateTime
     */
    public function getFechaIni()
    {
        return $this->fechaIni;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Servicio
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     *
     * @return Servicio
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
     * Set precio
     *
     * @param float $precio
     *
     * @return Servicio
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
     * Set iva
     *
     * @param float $iva
     *
     * @return Servicio
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
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Servicio
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

    public function setId($id) {
        $this->id = $id;
    }
}

