<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pf
 *
 * @ORM\Table(name="pf", indexes={@ORM\Index(name="fk_PF_Administrador1_idx", columns={"ModificadorId"}), @ORM\Index(name="fk_PF_Grupo1_idx", columns={"GrupoId"})})
 * @ORM\Entity(repositoryClass="GuiasDocentes\AppBundle\Entity\PfRepository")
 */
class Pf
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
     * @ORM\Column(name="pregunta", type="text", nullable=false)
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="text", nullable=false)
     */
    private $respuesta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitada", type="boolean", nullable=false)
     */
    private $habilitada = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="creador", type="string", length=30, nullable=true)
     */
    private $creador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaM", type="datetime", nullable=false)
     */
    private $fecham = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $orden = '0';

    /**
     * @var \Administrador
     *
     * @ORM\ManyToOne(targetEntity="Administrador", inversedBy="pfs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ModificadorId", referencedColumnName="id")
     * })
     */
    private $modificadorid;

    /**
     * @var \Grupo
     *
     * @ORM\ManyToOne(targetEntity="Grupo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="GrupoId", referencedColumnName="id")
     * })
     */
    private $grupoid;



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
     * Set pregunta
     *
     * @param string $pregunta
     * @return Pf
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
     * @return Pf
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
     * Set habilitada
     *
     * @param boolean $habilitada
     * @return Pf
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
     * Set creador
     *
     * @param string $creador
     * @return Pf
     */
    public function setCreador($creador)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return string 
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Set fecham
     *
     * @param \DateTime $fecham
     * @return Pf
     */
    public function setFecham($fecham)
    {
        $this->fecham = $fecham;

        return $this;
    }

    /**
     * Get fecham
     *
     * @return \DateTime 
     */
    public function getFecham()
    {
        return $this->fecham;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Pf
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
     * Set modificadorid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Administrador $modificadorid
     * @return Pf
     */
    public function setModificadorid(\GuiasDocentes\AppBundle\Entity\Administrador $modificadorid = null)
    {
        $this->modificadorid = $modificadorid;

        return $this;
    }

    /**
     * Get modificadorid
     *
     * @return \GuiasDocentes\AppBundle\Entity\Administrador 
     */
    public function getModificadorid()
    {
        return $this->modificadorid;
    }

    /**
     * Set grupoid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Grupo $grupoid
     * @return Pf
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
}
