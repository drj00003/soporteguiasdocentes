<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoSoporteHasPerfil
 *
 * @ORM\Table(name="grupo_soporte_has_perfil", indexes={@ORM\Index(name="fk_grupo_soporte_has_perfil_perfil1_idx", columns={"perfilNombre"}), @ORM\Index(name="fk_grupo_soporte_has_perfil_grupo_soporte1_idx", columns={"grupoSoporteId"})})
 * @ORM\Entity
 */
class GrupoSoporteHasPerfil
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
     * @var boolean
     *
     * @ORM\Column(name="habilitada", type="boolean", nullable=false)
     */
    private $habilitada;

    /**
     * @var \GrupoSoporte
     *
     * @ORM\ManyToOne(targetEntity="GrupoSoporte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupoSoporteId", referencedColumnName="id")
     * })
     */
    private $gruposoporteid;

    /**
     * @var \Perfil
     *
     * @ORM\ManyToOne(targetEntity="Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfilNombre", referencedColumnName="nombre")
     * })
     */
    private $perfilnombre;



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
     * Set habilitada
     *
     * @param boolean $habilitada
     * @return GrupoSoporteHasPerfil
     */
    public function setHabilitada($habilitada)
    {
        $this->habilitada = $habilitada;

        return $this;
    }

    /**
     * Get habilitada
     *
     * @return boolean 
     */
    public function getHabilitada()
    {
        return $this->habilitada;
    }

    /**
     * Set gruposoporteid
     *
     * @param \GuiasDocentes\AppBundle\Entity\GrupoSoporte $gruposoporteid
     * @return GrupoSoporteHasPerfil
     */
    public function setGruposoporteid(\GuiasDocentes\AppBundle\Entity\GrupoSoporte $gruposoporteid = null)
    {
        $this->gruposoporteid = $gruposoporteid;

        return $this;
    }

    /**
     * Get gruposoporteid
     *
     * @return \GuiasDocentes\AppBundle\Entity\GrupoSoporte 
     */
    public function getGruposoporteid()
    {
        return $this->gruposoporteid;
    }

    /**
     * Set perfilnombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilnombre
     * @return GrupoSoporteHasPerfil
     */
    public function setPerfilnombre(\GuiasDocentes\AppBundle\Entity\Perfil $perfilnombre = null)
    {
        $this->perfilnombre = $perfilnombre;

        return $this;
    }

    /**
     * Get perfilnombre
     *
     * @return \GuiasDocentes\AppBundle\Entity\Perfil 
     */
    public function getPerfilnombre()
    {
        return $this->perfilnombre;
    }
}
