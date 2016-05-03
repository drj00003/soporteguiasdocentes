<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personalEmail", referencedColumnName="email")
     * })
     */
    private $personalemail;

    /**
     * @var \Consultante
     *
     * @ORM\ManyToOne(targetEntity="Consultante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consultanteEmail", referencedColumnName="email")
     * })
     */
    private $consultanteemail;



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
