<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Asignatura
 *
 * @ORM\Table(name="asignatura")
 * @ORM\Entity
 */
class Asignatura
{
    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="integer", nullable=false)
     * @ORM\Id
     */
    private $codigo;
    
    /* Customized code */
    
    /**
     * @ORM\OneToMany(targetEntity="GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura", mappedBy="asignaturaCodigo")
     */
    private $consultaHasAsignaturas;
    
    public function __construct(){
        $this->consultaHasAsignaturas = new ArrayCollection();
    }
    
    public function addConsultasHasAsignatura(\GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura $consultaHasAsignatura){
        $this->consultaHasAsignaturas[] = $consultaHasAsignatura;
        
    }
    
    public function getConsultaHasAsignaturas (){
        return $this->consultaHasAsignaturas;
    }

    public function setConsultasHasAsignatura(\GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura $consultaHasAsignatura){
        $this->consultaHasAsignaturas[] = $consultaHasAsignatura;
        
    }
    
    public function setCodigo($codigo){
        $this->codigo =$codigo;
    }
    
    
    /* end customized code */


    /**
     * Get codigo
     *
     * @return integer 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
}
