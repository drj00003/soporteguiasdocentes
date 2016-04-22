<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 */
class Perfil
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $grupoSoporte;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $grupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupoSoporte = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set orden
     *
     * @param integer $orden
     * @return Perfil
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
     * Add grupoSoporte
     *
     * @param \GuiasDocentes\AppBundle\Entity\GrupoSoporte $grupoSoporte
     * @return Perfil
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

    /**
     * Add grupo
     *
     * @param \GuiasDocentes\AppBundle\Entity\Grupo $grupo
     * @return Perfil
     */
    public function addGrupo(\GuiasDocentes\AppBundle\Entity\Grupo $grupo)
    {
        $this->grupo[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param \GuiasDocentes\AppBundle\Entity\Grupo $grupo
     */
    public function removeGrupo(\GuiasDocentes\AppBundle\Entity\Grupo $grupo)
    {
        $this->grupo->removeElement($grupo);
    }

    /**
     * Get grupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
