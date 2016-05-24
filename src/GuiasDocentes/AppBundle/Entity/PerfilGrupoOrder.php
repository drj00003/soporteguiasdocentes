<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerfilGrupoOrder
 *
 * @ORM\Table(name="perfil_grupo_order", indexes={@ORM\Index(name="fk_Perfil_Grupo_Order_Perfil1_idx", columns={"perfilNombre"}), @ORM\Index(name="fk_Perfil_Grupo_Order_Grupo1", columns={"grupoId"})})
 * @ORM\Entity(repositoryClass="GuiasDocentes\AppBundle\Entity\PerfilGrupoOrderRepository")
 */
class PerfilGrupoOrder
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
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $orden;

    /**
     * @var \Grupo
     *
     * @ORM\ManyToOne(targetEntity="Grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupoId", referencedColumnName="id")
     * })
     */
    private $grupoid;

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
     * Set orden
     *
     * @param integer $orden
     * @return PerfilGrupoOrder
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
     * Set grupoid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Grupo $grupoid
     * @return PerfilGrupoOrder
     */
    public function setGrupoid(\GuiasDocentes\AppBundle\Entity\Grupo $grupoid = null)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return \GuiasDocentes\AppBundle\Entity\Grupo 
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set perfilnombre
     *
     * @param \GuiasDocentes\AppBundle\Entity\Perfil $perfilnombre
     * @return PerfilGrupoOrder
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
