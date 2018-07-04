<?php

namespace AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alquiler
 *
 * @ORM\Table(name="alquiler")
 * @ORM\Entity(repositoryClass="AdministracionBundle\Repository\AlquilerRepository")
 */
class Alquiler
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Propietario")
     * @ORM\JoinColumn(name="propietario", referencedColumnName="id")
     */
    private $propietario;

     /**
     * @ORM\ManyToOne(targetEntity="Local")
     * @ORM\JoinColumn(name="local", referencedColumnName="id")
     */
    private $local;

    /**
     * @var string
     *
     * @ORM\Column(name="plazomes", type="decimal", precision=6, scale=2)
     */
    private $plazomes;

    /**
     * @var string
     *
     * @ORM\Column(name="costoalquiler", type="decimal", precision=6, scale=2)
     */
    private $costoalquiler;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaalquiler", type="date")
     */
    private $fechaalquiler;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set propietario
     *
     * @param string $propietario
     *
     * @return Alquiler
     */
    public function setPropietario($propietario)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return string
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set local
     *
     * @param string $local
     *
     * @return Alquiler
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set plazomes
     *
     * @param string $plazomes
     *
     * @return Alquiler
     */
    public function setPlazomes($plazomes)
    {
        $this->plazomes = $plazomes;

        return $this;
    }

    /**
     * Get plazomes
     *
     * @return string
     */
    public function getPlazomes()
    {
        return $this->plazomes;
    }

    /**
     * Set costoalquiler
     *
     * @param string $costoalquiler
     *
     * @return Alquiler
     */
    public function setCostoalquiler($costoalquiler)
    {
        $this->costoalquiler = $costoalquiler;

        return $this;
    }

    /**
     * Get costoalquiler
     *
     * @return string
     */
    public function getCostoalquiler()
    {
        return $this->costoalquiler;
    }

    /**
     * Set fechaalquiler
     *
     * @param \DateTime $fechaalquiler
     *
     * @return Alquiler
     */
    public function setFechaalquiler($fechaalquiler)
    {
        $this->fechaalquiler = $fechaalquiler;

        return $this;
    }

    /**
     * Get fechaalquiler
     *
     * @return \DateTime
     */
    public function getFechaalquiler()
    {
        return $this->fechaalquiler;
    }
}
