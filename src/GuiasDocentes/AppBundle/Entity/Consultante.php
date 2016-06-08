<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GuiasDocentes\AppBundle\Entity\Hilo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Consultante
 *
 * @ORM\Table(name="consultante")
 * @ORM\Entity(repositoryClass="GuiasDocentes\AppBundle\Entity\ConsultanteRepository")
 */
class Consultante
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=50, nullable=true)
     */
    private $apellidos;

    /* Customized code */
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\Hilo", mappedBy="consultanteemail")
     * @Assert\Valid()
     */
    private $hilos;
    
    public function __construct(){
        $this->hilos = new ArrayCollection();
    }
    
    public function setConsultante($email, $nombre, $apellidos){
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setEmail($email);
    }
    
    public function setHilos (Hilo $hilo){
        $this->hilos[]=$hilo;
    }
    
    public function addHilo (\GuiasDocentes\AppBundle\Entity\Hilo $hilo){
        $this->hilos[] = $hilo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /* End customize code */

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
     * Set nombre
     *
     * @param string $nombre
     * @return Consultante
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
     * @return Consultante
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
}
