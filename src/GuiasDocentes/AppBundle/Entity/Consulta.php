<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consulta
 *
 * @ORM\Table(name="consulta", indexes={@ORM\Index(name="fk_Consulta_Hilo1_idx", columns={"hiloId"})})
 * @ORM\Entity
 */
class Consulta
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
     * @ORM\Column(name="texto", type="text", nullable=true)
     */
    private $texto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visto", type="boolean", nullable=true)
     */
    private $visto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var \Hilo
     *
     * @ORM\ManyToOne(targetEntity="Hilo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hiloId", referencedColumnName="id")
     * })
     */
    private $hiloid;



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
     * Set hiloid
     *
     * @param \GuiasDocentes\AppBundle\Entity\Hilo $hiloid
     * @return Consulta
     */
    public function setHiloid(\GuiasDocentes\AppBundle\Entity\Hilo $hiloid = null)
    {
        $this->hiloid = $hiloid;

        return $this;
    }

    /**
     * Get hiloid
     *
     * @return \GuiasDocentes\AppBundle\Entity\Hilo 
     */
    public function getHiloid()
    {
        return $this->hiloid;
    }
}
