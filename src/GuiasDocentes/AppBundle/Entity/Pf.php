<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pf
 */
class Pf
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pregunta;

    /**
     * @var string
     */
    private $respuesta;

    /**
     * @var boolean
     */
    private $habilitada;

    /**
     * @var string
     */
    private $creador;

    /**
     * @var \DateTime
     */
    private $fechaM;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Administrador
     */
    private $administrador;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Grupo
     */
    private $grupo;


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
     * Set fechaM
     *
     * @param \DateTime $fechaM
     * @return Pf
     */
    public function setFechaM($fechaM)
    {
        $this->fechaM = $fechaM;

        return $this;
    }

    /**
     * Get fechaM
     *
     * @return \DateTime 
     */
    public function getFechaM()
    {
        return $this->fechaM;
    }

    /**
     * Set administrador
     *
     * @param \GuiasDocentes\AppBundle\Entity\Administrador $administrador
     * @return Pf
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
     * Set grupo
     *
     * @param \GuiasDocentes\AppBundle\Entity\Grupo $grupo
     * @return Pf
     */
    public function setGrupo(\GuiasDocentes\AppBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \GuiasDocentes\AppBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
