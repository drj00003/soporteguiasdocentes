<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 */
class Respuesta
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Consulta
     */
    private $consulta;


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
     * Set texto
     *
     * @param string $texto
     * @return Respuesta
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Respuesta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set consulta
     *
     * @param \GuiasDocentes\AppBundle\Entity\Consulta $consulta
     * @return Respuesta
     */
    public function setConsulta(\GuiasDocentes\AppBundle\Entity\Consulta $consulta = null)
    {
        $this->consulta = $consulta;

        return $this;
    }

    /**
     * Get consulta
     *
     * @return \GuiasDocentes\AppBundle\Entity\Consulta 
     */
    public function getConsulta()
    {
        return $this->consulta;
    }
}
