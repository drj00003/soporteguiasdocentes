<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoSoporte
 *
 * @ORM\Table(name="grupo_soporte", indexes={@ORM\Index(name="fk_Grupo_Soporte_Administrador1_idx", columns={"administradorId"})})
 * @ORM\Entity
 */
class GrupoSoporte
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=true)
     */
    private $nombre;

    /**
     * @var \Administrador
     *
     * @ORM\ManyToOne(targetEntity="Administrador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="administradorId", referencedColumnName="id")
     * })
     */
    private $administradorid;



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
     * Set administradorid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Administrador $administradorid
     * @return GrupoSoporte
     */
    public function setAdministradorid(\GuiasDocentes\AppBundle\Entity\Administrador $administradorid = null)
    {
        $this->administradorid = $administradorid;

        return $this;
    }

    /**
     * Get administradorid
     *
     * @return \GuiasDocentes\AppBundle\Entity\Administrador 
     */
    public function getAdministradorid()
    {
        return $this->administradorid;
    }
}
