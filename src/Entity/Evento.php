<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */

class Evento
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nameCreador;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailCreador;

    /**
     * @ORM\Column(type="integer")
     */
    private $comunidadId;

    /**
     * @ORM\Column(type="integer")
     */
    private $provinciaId;

    /**
     * @ORM\Column(type="integer")
     */
    private $municipioId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     */
    private $events;

    public function getId()
    {
        return $this->id;
    }

    public function getNameCreador(): ?string
    {
        return $this->nameCreador;
    }

    public function setNameCreador(string $nameCreador): self
    {
        $this->nameCreador = $nameCreador;

        return $this;
    }

    public function getMailCreador(): ?string
    {
        return $this->nickCreador;
    }

    public function setMailCreador(string $mailCreador): self
    {
        $this->mailCreador = $mailCreador;

        return $this;
    }

    public function getComunidadId(): ?int
    {
        return $this->comunidadId;
    }

    public function setComunidadId(int $comunidadId): self
    {
        $this->comunidadId = $comunidadId;

        return $this;
    }

    public function getProvinciaId(): ?int
    {
        return $this->provinciaId;
    }

    public function setProvinciaId(int $provinciaId): self
    {
        $this->provinciaId = $provinciaId;

        return $this;
    }

    public function getMunicipioId(): ?int
    {
        return $this->municipioId;
    }

    public function setMunicipioId(int $municipioId): self
    {
        $this->municipioId = $municipioId;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEvents(): ?User
    {
        return $this->events;
    }

    public function setEvents(?User $events): self
    {
        $this->events = $events;

        return $this;
    }
}
