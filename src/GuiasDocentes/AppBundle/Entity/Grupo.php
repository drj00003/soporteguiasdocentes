<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 */
class Grupo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $perfilNombre;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->perfilNombre = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Grupo
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
     * Add perfilNombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre
     * @return Grupo
     */
    public function addPerfilNombre(\GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre)
    {
        $this->perfilNombre[] = $perfilNombre;

        return $this;
    }

    /**
     * Remove perfilNombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre
     */
    public function removePerfilNombre(\GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre)
    {
        $this->perfilNombre->removeElement($perfilNombre);
    }

    /**
     * Get perfilNombre
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPerfilNombre()
    {
        return $this->perfilNombre;
    }
}
