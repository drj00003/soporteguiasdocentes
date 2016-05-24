<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConsultaHasAsignatura
 *
 * @ORM\Table(name="consulta_has_asignatura", indexes={@ORM\Index(name="fk_consulta_has_asignatura_asignatura1_idx", columns={"asignaturaCodigo"}), @ORM\Index(name="fk_consulta_has_asignatura_consulta1_idx", columns={"consultaId"})})
 * @ORM\Entity
 */
class ConsultaHasAsignatura
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
     * @var \Asignatura
     *
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="consultaHasAsignaturas", cascade = {"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asignaturaCodigo", referencedColumnName="codigo")
     * })
     */
    private $asignaturaCodigo;

    /**
     * @var \Consulta
     *
     * @ORM\ManyToOne(targetEntity="Consulta", inversedBy="consultaHasAsignaturas", cascade = {"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consultaId", referencedColumnName="id")
     * })
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
     * Set asignaturaCodigo
     *
     * @param \GuiasDocentes\AppBundle\Entity\Asignatura $asignaturaCodigo
     * @return ConsultaHasAsignatura
     */
    public function setAsignaturaCodigo(\GuiasDocentes\AppBundle\Entity\Asignatura $asignaturaCodigo = null)
    {
        $this->asignaturaCodigo = $asignaturaCodigo;

        return $this;
    }

    /**
     * Get asignaturaCodigo
     *
     * @return \GuiasDocentes\AppBundle\Entity\Asignatura 
     */
    public function getAsignaturaCodigo()
    {
        return $this->asignaturaCodigo;
    }

    /**
     * Set consulta
     *
     * @param \GuiasDocentes\AppBundle\Entity\Consulta $consulta
     * @return ConsultaHasAsignatura
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
