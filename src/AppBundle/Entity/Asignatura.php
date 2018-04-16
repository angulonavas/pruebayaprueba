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

    public function __construct()
    {
        $this->temarios = new ArrayCollection();
        $this->categorias = new ArrayCollection();
        $this->documentos = new ArrayCollection();
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
     * Get temarios: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function getTemarios() {
        return array_reverse($this->temarios->toArray());
    }

    /**
     * Get categorías: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function getCategorias() {
        return array_reverse($this->categorias->toArray());
    }

    /**
     * Get documentos: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function getDocumentos() {
        return array_reverse($this->documentos->toArray());
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

