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
     * @var \GuiasDocentes\AppBundle\Entity\Perfil
     */
    private $perfilNombre;


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
     * Set perfilNombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre
     * @return Grupo
     */
    public function setPerfilNombre(\GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre = null)
    {
        $this->perfilNombre = $perfilNombre;

        return $this;
    }

    /**
     * Get perfilNombre
     *
     * @return \GuiasDocentes\AppBundle\Entity\Perfil 
     */
    public function getPerfilNombre()
    {
        return $this->perfilNombre;
    }
}
