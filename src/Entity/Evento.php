<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"read"}},
 *     "denormalization_context"={"groups"={"write"}}
 * })
 * @ApiFilter(DateFilter::class)
 */


class Evento
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @ApiProperty(iri="http://meet.in/nameCreador/")
     * @Groups({"read", "write"})
     */
    private $nameCreador;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $mailCreador;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read", "write"})
     */
    private $municipioId;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read", "write"})
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date")
     * @Groups({"read", "write"})
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $id_creator;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="events_joined")
     * @Groups({"none"})
     *
     */
    private $users_joined;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read", "write"})
     */
    private $subscribers;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $isExpired;

    public function __construct()
    {
        $this->users_joined = new ArrayCollection();
    }


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
        return $this->mailCreador;
    }

    public function setMailCreador(string $mailCreador): self
    {
        $this->mailCreador = $mailCreador;

        return $this;
    }

    public function getMunicipioId(): ?string
    {
        return $this->municipioId;
    }

    public function setMunicipioId(string $municipioId): self
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

    public function getIdCreator(): ?User
    {
        return $this->id_creator;
    }

    public function setIdCreator(?User $id_creator): self
    {
        $this->id_creator = $id_creator;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersJoined(): Collection
    {
        return $this->users_joined;
    }

    public function addUsersJoined(User $usersJoined): self
    {
        if (!$this->users_joined->contains($usersJoined)) {
            $this->users_joined[] = $usersJoined;
            $usersJoined->addEventsJoined($this);
        }

        return $this;
    }

    public function removeUsersJoined(User $usersJoined): self
    {
        if ($this->users_joined->contains($usersJoined)) {
            $this->users_joined->removeElement($usersJoined);
            $usersJoined->removeEventsJoined($this);
        }

        return $this;
    }

    public function getSubscribers(): ?int
    {
        return $this->subscribers;
    }

    public function setSubscribers(int $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }

    public function getIsExpired(): ?bool
    {
        return $this->isExpired;
    }

    public function setIsExpired(bool $isExpired): self
    {
        $this->isExpired = $isExpired;

        return $this;
    }
}
