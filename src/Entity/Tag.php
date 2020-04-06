<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 *
 **/
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Interest", mappedBy="tag", orphanRemoval=true)
     */
    private $usersInterested;

    public function __construct()
    {
        $this->usersInterested = new ArrayCollection();
    }



    public function getId()
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Interest[]
     */
    public function getUsersInterested(): Collection
    {
        return $this->usersInterested;
    }

    public function addUsersInterested(Interest $usersInterested): self
    {
        if (!$this->usersInterested->contains($usersInterested)) {
            $this->usersInterested[] = $usersInterested;
            $usersInterested->setTag($this);
        }

        return $this;
    }

    public function removeUsersInterested(Interest $usersInterested): self
    {
        if ($this->usersInterested->contains($usersInterested)) {
            $this->usersInterested->removeElement($usersInterested);
            // set the owning side to null (unless already changed)
            if ($usersInterested->getTag() === $this) {
                $usersInterested->setTag(null);
            }
        }

        return $this;
    }
}
