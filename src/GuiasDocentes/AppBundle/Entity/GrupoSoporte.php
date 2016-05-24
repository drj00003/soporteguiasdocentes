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
     * @ORM\Column(name="nombre", type="text", nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="pregunta", type="text", nullable=true)
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="text", nullable=true)
     */
    private $respuesta;

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
     * Set pregunta
     *
     * @param string $pregunta
     * @return GrupoSoporte
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta
     * @return GrupoSoporte
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
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
