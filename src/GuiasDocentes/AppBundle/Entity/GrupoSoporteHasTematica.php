<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoSoporteHasTematica
 *
 * @ORM\Table(name="grupo_soporte_has_tematica", indexes={@ORM\Index(name="fk_Grupo_Soporte_has_Temática_Temática1_idx", columns={"tematicaId"}), @ORM\Index(name="fk_Grupo_Soporte_has_Temática_Grupo_Soporte1_idx", columns={"grupoSoporteId"})})
 * @ORM\Entity
 */
class GrupoSoporteHasTematica
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
     * @var \GrupoSoporte
     *
     * @ORM\ManyToOne(targetEntity="GrupoSoporte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupoSoporteId", referencedColumnName="id")
     * })
     */
    private $gruposoporteid;

    /**
     * @var \Tematica
     *
     * @ORM\ManyToOne(targetEntity="Tematica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tematicaId", referencedColumnName="id")
     * })
     */
    private $tematicaid;



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
     * Set gruposoporteid
     *
     * @param \GuiasDocentes\AppBundle\Entity\GrupoSoporte $gruposoporteid
     * @return GrupoSoporteHasTematica
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
     * Set tematicaid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Tematica $tematicaid
     * @return GrupoSoporteHasTematica
     */
    public function setTematicaid(\GuiasDocentes\AppBundle\Entity\Tematica $tematicaid = null)
    {
        $this->tematicaid = $tematicaid;

        return $this;
    }

    /**
     * Get tematicaid
     *
     * @return \GuiasDocentes\AppBundle\Entity\Tematica 
     */
    public function getTematicaid()
    {
        return $this->tematicaid;
    }
}
