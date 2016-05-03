<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tematica
 *
 * @ORM\Table(name="tematica", indexes={@ORM\Index(name="fk_Temática_Personal1_idx", columns={"personalEmail"})})
 * @ORM\Entity
 */
class Tematica
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
     * @ORM\Column(name="enunciado", type="string", length=45, nullable=true)
     */
    private $enunciado;

    /**
     * @var string
     *
     * @ORM\Column(name="tematica", type="string", length=45, nullable=true)
     */
    private $tematica;

    /**
     * @var \Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personalEmail", referencedColumnName="email")
     * })
     */
    private $personalemail;



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
     * Set enunciado
     *
     * @param string $enunciado
     * @return Tematica
     */
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;

        return $this;
    }

    /**
     * Get enunciado
     *
     * @return string 
     */
    public function getEnunciado()
    {
        return $this->enunciado;
    }

    /**
     * Set tematica
     *
     * @param string $tematica
     * @return Tematica
     */
    public function setTematica($tematica)
    {
        $this->tematica = $tematica;

        return $this;
    }

    /**
     * Get tematica
     *
     * @return string 
     */
    public function getTematica()
    {
        return $this->tematica;
    }

    /**
     * Set personalemail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalemail
     * @return Tematica
     */
    public function setPersonalemail(\GuiasDocentes\AppBundle\Entity\Personal $personalemail = null)
    {
        $this->personalemail = $personalemail;

        return $this;
    }

    /**
     * Get personalemail
     *
     * @return \GuiasDocentes\AppBundle\Entity\Personal 
     */
    public function getPersonalemail()
    {
        return $this->personalemail;
    }
}
