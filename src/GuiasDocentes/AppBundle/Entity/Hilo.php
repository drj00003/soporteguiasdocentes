<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hilo
 */
class Hilo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Consultante
     */
    private $consultanteEmail;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Personal
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
     * Set consultanteEmail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Consultante $consultanteEmail
     * @return Hilo
     */
    public function setConsultanteEmail(\GuiasDocentes\AppBundle\Entity\Consultante $consultanteEmail = null)
    {
        $this->consultanteEmail = $consultanteEmail;

        return $this;
    }

    /**
     * Get consultanteEmail
     *
     * @return \GuiasDocentes\AppBundle\Entity\Consultante 
     */
    public function getConsultanteEmail()
    {
        return $this->consultanteEmail;
    }

    /**
     * Set personalEmail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalEmail
     * @return Hilo
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
}
