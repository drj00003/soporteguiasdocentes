<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use GuiasDocentes\AppBundle\Entity\Consultante;
use GuiasDocentes\AppBundle\Entity\Personal;


/**
 * Hilo
 *
 * @ORM\Table(name="hilo", indexes={@ORM\Index(name="fk_Hilo_Personal1_idx", columns={"personalEmail"}), @ORM\Index(name="fk_Hilo_Consultante1_idx", columns={"consultanteEmail"})})
 * @ORM\Entity
 */
class Hilo
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
     * @var \GuiasDocentes\AppBundle\Entity\Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal", inversedBy="hilos", cascade ={"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personalEmail", referencedColumnName="email")
     * })
     */
    private $personalemail;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Consultante
     *
     * @ORM\ManyToOne(targetEntity="Consultante", inversedBy="hilos", cascade ={"ALL"} )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consultanteEmail", referencedColumnName="email")
     * })
     */
    private $consultanteemail;
    
    
    /* Customized code */
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\Consulta", mappedBy="hiloid")
     * @Assert\Valid()
     */
    private $consultas;
    
    public function __construct(){
        
        $this->consultas = new ArrayCollection();
    }
    
    public function setConsultas (Consulta $consulta){
        $this->hilos[]=$consulta;
    }
    
    public function addConsulta (\GuiasDocentes\AppBundle\Entity\Consulta $consulta){
        $this->hilos[] = $consulta;
    }
    
    public function getConsultas(){
        return $this->consultas;
    }
    
    /* End customized code */
    

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
     * Set personalemail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalemail
     * @return Hilo
     */
    public function setPersonalemail(\GuiasDocentes\AppBundle\Entity\Personal $personalemail = null)
    {

        $this->personalemail = $personalemail;

        return $this;
    }

    /**
     * Get personalemail
     *
     * @return \GuiasDocentes\AppBundle\Entity\Personal 
     */
    public function getPersonalemail()
    {
        return $this->personalemail;
    }

    /**
     * Set consultanteemail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Consultante $consultanteemail
     * @return Hilo
     */
    public function setConsultanteemail(\GuiasDocentes\AppBundle\Entity\Consultante $consultanteemail = null)
    {
        $this->consultanteemail = $consultanteemail;

        return $this;
    }

    /**
     * Get consultanteemail
     *
     * @return \GuiasDocentes\AppBundle\Entity\Consultante 
     */
    public function getConsultanteemail()
    {
        return $this->consultanteemail;
    }
}
