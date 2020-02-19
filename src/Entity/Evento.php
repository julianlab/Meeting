<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=100)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $id_creator;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="events_joined")
     *
     */
    private $users_joined;

    /**
     * @ORM\Column(type="integer")
     */
    private $subscribers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isExpired;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag")
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct()
    {
        $this->users_joined = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
