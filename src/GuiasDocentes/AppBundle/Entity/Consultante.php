<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultante
 */
class Consultante
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellidos;


    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Consultante
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Consultante
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }
}
