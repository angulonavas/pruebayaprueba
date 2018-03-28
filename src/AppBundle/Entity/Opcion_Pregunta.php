<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opcion_Pregunta
 *
 * @ORM\Table(name="opcion__pregunta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Opcion_PreguntaRepository")
 */
class Opcion_Pregunta
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
     * @ORM\Column(name="descripcion", type="string", length=256)
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
     * @ORM\Column(name="cierta", type="boolean")
     */
    private $cierta;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta_Examen", inversedBy="opciones")
     * @ORM\JoinColumn(name="id_pregunta_examen", referencedColumnName="id")
     */
    private $pregunta_examen;

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
     * @return Opcion_Pregunta
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Opcion_Pregunta
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
     * Set cierta
     *
     * @param boolean $cierta
     *
     * @return Opcion_Pregunta
     */
    public function setCierta($cierta)
    {
        $this->cierta = $cierta;

        return $this;
    }

    /**
     * Get cierta
     *
     * @return bool
     */
    public function getCierta()
    {
        return $this->cierta;
    }

    /**
     * Set pregunta_examen
     *
     * @param integer $pregunta_examen
     *
     * @return Opcion_Pregunta
     */
    public function setPregunta_Examen($pregunta_examen)
    {
        $this->pregunta_examen = $pregunta_examen;

        return $this;
    }

    /**
     * Get pregunta_examen
     *
     * @return Pregunta_Examen
     */
    public function getPregunta_Examen()
    {
        return $this->pregunta_examen;
    }    
}

