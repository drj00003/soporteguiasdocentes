<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil")
 * @ORM\Entity(repositoryClass="GuiasDocentes\AppBundle\Entity\PerfilRepository")
 */
class Perfil
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * @ORM\Id
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Perfil
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }    

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Perfil
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
