<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temática
 */
class Temática
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $enunciado;

    /**
     * @var string
     */
    private $tematica;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Personal
     */
    private $personalEmail;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $grupoSoporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupoSoporte = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Temática
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
     * Set tematica
     *
     * @param string $tematica
     * @return Temática
     */
    public function setTematica($tematica)
    {
        $this->tematica = $tematica;

        return $this;
    }

    /**
     * Get tematica
     *
     * @return string 
     */
    public function getTematica()
    {
        return $this->tematica;
    }

    /**
     * Set personalEmail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalEmail
     * @return Temática
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

    /**
     * Add grupoSoporte
     *
     * @param \GuiasDocentes\AppBundle\Entity\GrupoSoporte $grupoSoporte
     * @return Temática
     */
    public function addGrupoSoporte(\GuiasDocentes\AppBundle\Entity\GrupoSoporte $grupoSoporte)
    {
        $this->grupoSoporte[] = $grupoSoporte;

        return $this;
    }

    /**
     * Remove grupoSoporte
     *
     * @param \GuiasDocentes\AppBundle\Entity\GrupoSoporte $grupoSoporte
     */
    public function removeGrupoSoporte(\GuiasDocentes\AppBundle\Entity\GrupoSoporte $grupoSoporte)
    {
        $this->grupoSoporte->removeElement($grupoSoporte);
    }

    /**
     * Get grupoSoporte
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupoSoporte()
    {
        return $this->grupoSoporte;
    }
}
