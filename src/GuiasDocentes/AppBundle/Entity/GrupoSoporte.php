<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoSoporte
 */
class GrupoSoporte
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
     * @var \GuiasDocentes\AppBundle\Entity\Administrador
     */
    private $administrador;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $perfilNombre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $temática;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->perfilNombre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->temática = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return GrupoSoporte
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
     * Set administrador
     *
     * @param \GuiasDocentes\AppBundle\Entity\Administrador $administrador
     * @return GrupoSoporte
     */
    public function setAdministrador(\GuiasDocentes\AppBundle\Entity\Administrador $administrador = null)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return \GuiasDocentes\AppBundle\Entity\Administrador 
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Add perfilNombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilNombre
     * @return GrupoSoporte
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

    /**
     * Add temática
     *
     * @param \GuiasDocentes\AppBundle\Entity\Temática $temática
     * @return GrupoSoporte
     */
    public function addTemática(\GuiasDocentes\AppBundle\Entity\Temática $temática)
    {
        $this->temática[] = $temática;

        return $this;
    }

    /**
     * Remove temática
     *
     * @param \GuiasDocentes\AppBundle\Entity\Temática $temática
     */
    public function removeTemática(\GuiasDocentes\AppBundle\Entity\Temática $temática)
    {
        $this->temática->removeElement($temática);
    }

    /**
     * Get temática
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemática()
    {
        return $this->temática;
    }
}
