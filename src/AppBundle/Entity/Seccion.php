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
     * @var float
     *
     * @ORM\Column(name="iva", type="float")
     */
    private $iva = 11;

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

   /**
     * @ORM\OneToMany(targetEntity="Consulta", mappedBy="seccion")
     */
    private $consulta;
    private $isConsulta;

    // Si el usuario está o no matriculado en la sección
    private $matriculado;




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
     * Set orden
     *
     * @param string $orden
     *
     * @return Seccion
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return string
     */
    public function getOrden()
    {
        return $this->orden;
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
     * Set iva
     *
     * @param float $iva
     *
     * @return Seccion
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
        return ($this->anterior) ? $this->anterior : $this; 
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
        return ($this->posterior) ? $this->posterior : $this; 
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

       /**
     * Get consultas: si no está formateado, primero llama para formatear el array de consultas.
     * Después devuelve el array formateado
     * @return Array
     */
    public function getConsultas() {
        if (!$this->isConsultas) $this->setConsultas();
        return $this->consultas;
    } 

    /**
     * Get consultas: transforma un ArrayCollection en un array y le da la vuelta.
     * Después devuelve un array
     * @return Array
     */
    public function setConsultas() {
        
        // 1.- Se define vector auxiliar y se transforma arraycollectionen array
        $vector_aux = [];
        $this->consultas = $this->consultas->toArray();

        // 2.- Por cada item del array rellenaremos el vector auxiliar con el campo que se desea ordenar
        foreach($this->consultas as $i => $consulta) { 
            $vector_aux[$i] = $consulta->getFecha(); 
        }

        // 3.- Ordenamos definitivamente el vector en base a la ordenación del vector auxiliar
        array_multisort($vector_aux, $this->consultas);

        // 4.- Se indica que ya se ha ejecutado la ordenación y cada vez que se llame a getConsultas no será
        // preciso volver a ejectuar todo el trabajo
        $this->isSecciones = true;
    }  
}

