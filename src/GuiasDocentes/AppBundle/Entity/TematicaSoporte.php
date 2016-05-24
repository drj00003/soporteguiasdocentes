<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TematicaSoporte
 *
 * @ORM\Table(name="tematica_soporte", indexes={@ORM\Index(name="fk_tematica_soporte_personal1_idx", columns={"personalEmail"})})
 * @ORM\Entity
 */
class TematicaSoporte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="enunciado", type="text", nullable=true)
     */
    private $enunciado;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $orden;

    /**
     * @var \Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal", inversedBy="tematicasSoporte", cascade={"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personalEmail", referencedColumnName="email")
     * })
     */
    private $personalEmail;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set enunciado
     *
     * @param string $enunciado
     * @return TematicaSoporte
     */
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;

        return $this;
    }

    /**
     * Get enunciado
     *
     * @return string 
     */
    public function getEnunciado()
    {
        return $this->enunciado;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return TematicaSoporte
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set personalEmail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalEmail
     * @return TematicaSoporte
     */
    public function setPersonalEmail(\GuiasDocentes\AppBundle\Entity\Personal $personalEmail = null)
    {
        $this->personalEmail = $personalEmail;

        return $this;
    }

    /**
     * Get personalEmail
     *
     * @return \GuiasDocentes\AppBundle\Entity\Personal 
     */
    public function getPersonalEmail()
    {
        return $this->personalEmail;
    }
    
    
    /* Customized code */
    
    public function __toString(){
        $array= array('email' => $this->getPersonalEmail()->getEmail(), 'nombre' =>$this->getPersonalEmail()->getNombre(), 'apellidos' => $this->getPersonalEmail()->getApellidos(), 'departamento' => $this->getPersonalEmail()->getDepartamento());
        return $array;
    }
    
    
    /* End customized code */
}
