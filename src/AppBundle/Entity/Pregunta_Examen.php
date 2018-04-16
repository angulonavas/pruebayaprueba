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
     * Para ordenar el array de opciones por un campo deseado mirar getOpciones()
     * Para evitar hacer el trabajo de reordenación por un campo deseado se precisa una llave: $isOpciones
     */
    private $opciones;
    private $isOpciones = false;



    public function __construct()
    {
        $this->opciones = new ArrayCollection();
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

    /**
     * Get opciones: si no está formateado, primero llama para formatear el array de opciones.
     * Después devuelve el array formateado
     * @return Array
     */
    public function getOpciones() {
        if (!$this->isOpciones) $this->setOpciones();
        return $this->opciones;
    } 

    /**
     * Get opciones: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function setOpciones() {
        
        // 1.- Se define vector auxiliar y se transforma arraycollectionen array
        $vector_aux = [];
        $this->opciones = $this->opciones->toArray();

        // 2.- Por cada item del array rellenaremos el vector auxiliar con el campo que se desea ordenar
        foreach($this->opciones as $i => $opcion) { 
            $vector_aux[$i] = $opcion->getOrden(); 
        }

        // 3.- Ordenamos definitivamente el vector en base a la ordenación del vector auxiliar
        array_multisort($vector_aux, $this->opciones);

        // 4.- Se indica que ya se ha ejecutado la ordenación y cada vez que se llame a getOpciones no será
        // preciso volver a ejectuar todo el trabajo
        $this->isSecciones = true;
    }         
}

