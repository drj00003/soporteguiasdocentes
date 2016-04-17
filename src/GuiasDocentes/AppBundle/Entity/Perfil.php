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
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
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
}
