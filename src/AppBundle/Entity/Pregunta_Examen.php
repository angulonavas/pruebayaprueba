<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pregunta_Examen
 *
 * @ORM\Table(name="pregunta__examen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Pregunta_ExamenRepository")
 */
class Pregunta_Examen
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
     * @ORM\Column(name="descripcion", type="string", length=128)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="preguntas_examen")
     * @ORM\JoinColumn(name="id_seccion", referencedColumnName="id")
     */
    private $seccion;

    /**
     * @ORM\OneToMany(targetEntity="Opcion_Pregunta", mappedBy="pregunta_examen")
     */
    private $opcion_pregunta;



    public function __construct()
    {
        $this->opcion_pregunta = new ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pregunta_Examen
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
     * @return Pregunta_Examen
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
     * Set seccion
     *
     * @param integer $seccion
     *
     * @return Pregunta_Examen
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return Seccion
     */
    public function getSeccion()
    {
        return $this->seccion;
    }    
}

