<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Asignatura
 *
 * @ORM\Table(name="asignatura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsignaturaRepository")
 */
class Asignatura
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
     * @var bool
     *
     * @ORM\Column(name="publicado", type="boolean", options={"default" : true})
     */
    private $publicado;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=16)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="disenyo", type="string", length=32)
     */
    private $disenyo;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer", options={"default" : 0})
     */
    private $orden;    

    /**
     * @ORM\OneToMany(targetEntity="Temario", mappedBy="asignatura")
     */
    private $temarios;

    /**
     * @ORM\OneToMany(targetEntity="Categoria", mappedBy="asignatura")
     */
    private $categorias;

    /**
     * @ORM\OneToMany(targetEntity="Documento", mappedBy="asignatura")
     */
    private $documentos;    

    /**
     * @ORM\OneToMany(targetEntity="Foro_Asignatura", mappedBy="asignatura")
     */
    private $foros_asignatura;

    /**
     * @ORM\OneToMany(targetEntity="Consulta", mappedBy="asignatura")
     */
    private $consultas;



    public function __construct()
    {
        $this->categorias = new ArrayCollection();
        $this->foros_asignatura = new ArrayCollection();
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
     * @return Asignatura
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
     * @return Asignatura
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
     * @return Asignatura
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Asignatura
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set disenyo
     *
     * @param string $disenyo
     *
     * @return Asignatura
     */
    public function setDisenyo($disenyo)
    {
        $this->disenyo = $disenyo;

        return $this;
    }

    /**
     * Get disenyo
     *
     * @return string
     */
    public function getDisenyo()
    {
        return $this->disenyo;
    }

   /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Asignatura
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

    // devuelve un array de temarios
    public function getTemarios() {
        return $this->temarios;
    }

    // carga el vector de temarios
    public function setTemarios($temarios) {
        $this->temarios = $temarios;
    }

    /**
     * Get categorías: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function getCategorias() {
        return array_reverse($this->categorias->toArray());
    }

    // devuelve un array de documentos
    public function getDocumentos() {
        return $this->documentos;
    }  

    // asigna un vector de documentos
    public function setDocumentos($documentos) {
        $this->documentos = $documentos;
    }

    // devuelve un array de consultas
    public function getConsultas() {
        return $this->consultas;
    }

    // carga el vector de temarios
    public function setConsultas($consultas) {
        $this->consultas = $consultas;
    }

    /**
     * Get foros: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function getForos() {
        return array_reverse($this->foros_asignatura->toArray());
    }    
}

