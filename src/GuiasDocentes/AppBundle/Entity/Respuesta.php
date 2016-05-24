<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Respuesta
 *
 * @ORM\Table(name="respuesta", indexes={@ORM\Index(name="fk_Respuesta_Consulta1_idx", columns={"ConsultaId"})})
 * @ORM\Entity
 */
class Respuesta
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var \Consulta
     *
     * @ORM\ManyToOne(targetEntity="Consulta", inversedBy="respuestas", cascade={"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ConsultaId", referencedColumnName="id")
     * })
     */
    private $consulta;


    /* Customized code */
    
    public function __constructor(){
        $this->setFecha(new \Datetime());
    }
    
    
    /* End customized code */


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
