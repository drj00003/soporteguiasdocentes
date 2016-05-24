<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GuiasDocentes\AppBundle\Entity\TematicaSoporte;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Personal
 *
 * @ORM\Table(name="personal")
 * @ORM\Entity(repositoryClass="GuiasDocentes\AppBundle\Entity\PersonalRepository")
 */
class Personal
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=20, nullable=true)
     */
    private $departamento;

    /* Customized code */
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\TematicaSoporte", mappedBy="personalEmail")
     * @Assert\Valid()
     */    
    private $tematicasSoporte;
    
    public function __constructor(){
        $this->tematicasSoporte = new ArrayCollection();
        $this->hilos = new ArrayCollection();
    }
    
    public function addTematicasSoporte(\GuiasDocentes\AppBundle\Entity\TematicaSoporte $tematicaSoporte){
        $this->tematicasSoporte[] = $tematicaSoporte;
        return $this;
    }    
    
    public function setTematicasSoporte(\GuiasDocentes\AppBundle\Entity\TematicaSoporte $tematicaSoporte){
        $this->tematicasSoporte[] = $tematicaSoporte;
        return $this;
    }
    
    public function getTematicasSoporte(){
        return $this->tematicasSoporte;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\Hilo", mappedBy="personalemail")
     * @Assert\Valid()
     */    
    private $hilos;
    
    public function setHilos(Hilo $hilo){
        $this->hilos[] = $hilo;
        return $this;
    }
    
        public function addHilos(Hilo $hilo){
        $this->hilos[] = $hilo;
        return $this;
    }
    
    public function getHilos(){
        return $this->hilos;
    }
    
    /* Esta funcion tiene problemas, sino tiene asociado un personal una tematica Evidentemente no puede coger su enunciado
    sobre todo el problema es que no te los da ordenados*/
    
    public function getEnunciado(){
        return $this->getTematicasSoporte()[0]->getEnunciado();
    }
    
    
    /* End customized code */
    
    
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
     * @return Personal
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
     * @return Personal
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
     * Set departamento
     *
     * @param string $departamento
     * @return Personal
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }


}
