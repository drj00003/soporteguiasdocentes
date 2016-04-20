<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consulta
 */
class Consulta
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
     * @var boolean
     */
    private $visto;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \GuiasDocentes\AppBundle\Entity\Hilo
     */
    private $hilo;


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
     * @return Consulta
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
     * Set visto
     *
     * @param boolean $visto
     * @return Consulta
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return boolean 
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Consulta
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
     * Set hilo
     *
     * @param \GuiasDocentes\AppBundle\Entity\Hilo $hilo
     * @return Consulta
     */
    public function setHilo(\GuiasDocentes\AppBundle\Entity\Hilo $hilo = null)
    {
        $this->hilo = $hilo;

        return $this;
    }

    /**
     * Get hilo
     *
     * @return \GuiasDocentes\AppBundle\Entity\Hilo 
     */
    public function getHilo()
    {
        return $this->hilo;
    }
}
