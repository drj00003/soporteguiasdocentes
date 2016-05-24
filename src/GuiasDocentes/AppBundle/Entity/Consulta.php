<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @ORM\ManyToOne(targetEntity="Hilo", inversedBy="consultas", cascade={"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hiloId", referencedColumnName="id")
     * })
     */
    private $hiloid;

    /* Customized code */
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura", mappedBy="consulta")
     * @Assert\Valid()
     */
    private $consultaHasAsignaturas;
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\Respuesta", mappedBy="consulta")
     * @Assert\Valid()
     */
    private $respuestas;
    
    public function __construct(){
        $this->consultaHasAsignaturas = new ArrayCollection();
        $this->respuetas = new ArrayCollection();
        $this->setFecha(new \Datetime());
        $this->visto =0;
    }
    
    public function addConsultasHasAsignatura(\GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura $consultaHasAsignatura){
        $this->consultaHasAsignaturas[] = $consultaHasAsignatura;
        
    }
    
    public function getConsultaHasAsignaturas (){
        return $this->consultaHasAsignaturas;
    }
    
    public function setConsultaHasAsignaturas (\GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura $consultaHasAsignatura){
        $this->consultaHasAsignaturas[] = $consultaHasAsignatura;
    }
    
    public function addRespuestas(\GuiasDocentes\AppBundle\Entity\Respuesta $respuesta){
        $this->respuestas[] = $respuesta;
        
    }
    
    public function getRespuestas (){
        return $this->respuestas;
    }
    
    public function setRespuestas (\GuiasDocentes\AppBundle\Entity\Respuesta $respuesta){
        $this->respuestas[] = $respuesta;
    }
    
    /* end customized code */
    

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
