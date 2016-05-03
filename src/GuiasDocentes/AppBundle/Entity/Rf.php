<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rf
 *
 * @ORM\Table(name="rf", indexes={@ORM\Index(name="fk_RF_Personal1_idx", columns={"personalEmail"})})
 * @ORM\Entity
 */
class Rf
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
     * @ORM\Column(name="texto", type="text", nullable=false)
     */
    private $texto;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=25, nullable=true)
     */
    private $keywords;

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
     * Set texto
     *
     * @param string $texto
     * @return Rf
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
     * Set keywords
     *
     * @param string $keywords
     * @return Rf
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set personalemail
     *
     * @param \GuiasDocentes\AppBundle\Entity\Personal $personalemail
     * @return Rf
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
