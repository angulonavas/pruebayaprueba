<?php

namespace SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="SeguridadBundle\Repository\UsuarioRepository")
 * @UniqueEntity(
 *     fields="username",
 *     message="Ya existe el usuario, por favor, utiliza otro" 
 * )
 * @UniqueEntity(
 *     fields="email",
 *     message="Ya estás registrado con nostros. ¿Olvidaste tu clave?" 
 * )
 */
class Usuario implements AdvancedUserInterface {
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
     * @ORM\Column(name="username", type="string", length=32, unique=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 32,
     *      minMessage = "Tu nombre de usuario debe ser mayor que {{ limit }} caracteres",
     *      maxMessage = "Tu nombre de usuario no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, unique=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 64,
     *      minMessage = "Tu email debe ser mayor que {{ limit }} caracteres",
     *      maxMessage = "Tu email no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\Length(
     *      min = 4,
     *      max = 64,
     *      minMessage = "La clave debe ser mayor que {{ limit }} caracteres",
     *      maxMessage = "La clave no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=64, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=16)
     */
    private $rol;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=16)
     * @Assert\Length(
     *      min = 1,
     *      max = 16,
     *      minMessage = "Tu nombre debe ser mayor que {{ limit }} caracteres",
     *      maxMessage = "Tu nombre no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=32)
     * @Assert\Length(
     *      min = 4,
     *      max = 32,
     *      minMessage = "Tus apellidos deben ser mayor que {{ limit }} caracteres",
     *      maxMessage = "Tus apellidos no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="universidad", type="string", length=32)     
     * @Assert\Length(
     *      min = 4,
     *      max = 32,
     *      minMessage = "El nombre de universidad debe ser mayor que {{ limit }} caracteres",
     *      maxMessage = "el nombre de universidad no puede ser mayor de {{ limit }} caracteres"
     * )
     */
    private $universidad;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Matricula_Servicios", mappedBy="usuario")
     */
    private $matriculas_servicios;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Matricula_Temarios", mappedBy="usuario")
     */
    private $matriculas_temarios;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Matricula_Secciones", mappedBy="usuario")
     */
    private $matriculas_secciones;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Documento", mappedBy="usuario")
     */
    private $documentos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Consulta", mappedBy="usuario")
     */
    private $consultas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Respuesta", mappedBy="usuario")
     */
    private $respuestas;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Factura", mappedBy="usuario")
     */
    private $facturas;                



    public function __construct()
    {
        $this->matriculas_servicios = new ArrayCollection();
        $this->matriculas_temarios = new ArrayCollection();
        $this->matriculas_secciones = new ArrayCollection();
        $this->documentos = new ArrayCollection();
        $this->consultas = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
        $this->facturas = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Usuario
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
     * Set rol
     *
     * @param string $rol
     *
     * @return Usuario
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set universidad
     *
     * @param string $universidad
     *
     * @return Usuario
     */
    public function setUniversidad($universidad)
    {
        $this->universidad = $universidad;

        return $this;
    }

    /**
     * Get universidad
     *
     * @return string
     */
    public function getUniversidad()
    {
        return $this->universidad;
    }
/*
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ) = unserialize($serialized);
    }
*/
    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->rol);
        //return array('ROLE_ALUMNO');
    }

    public function eraseCredentials() 
    {
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }    
}

