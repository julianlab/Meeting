<?php

namespace App\Entity;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="friendsWithMe")
     */
    private $myFriends;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="myFriends")
     */
    private $friendsWithMe;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="id_creator", cascade={"remove"} )
     */
    private $eventos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evento", inversedBy="users_joined")
     * @ORM\JoinTable(name="user_evento")
     */
    private $events_joined;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag")
     */
    private $interests;



    public function __construct(){
        parent::__construct();
        $this->myFriends = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->eventos = new ArrayCollection();
        $this->events_joined = new ArrayCollection();
        $this->interests = new ArrayCollection();
        //my own logic xd
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMyFriends(): Collection
    {
        return $this->myFriends;
    }

    public function addMyFriend(User $myFriend): self
    {
        if (!$this->myFriends->contains($myFriend)) {
            $this->myFriends[] = $myFriend;
            $myFriend->addMyFriend($this);
        }

        return $this;
    }

    public function removeMyFriend(User $myFriend): self
    {
        if ($this->myFriends->contains($myFriend)) {
            $this->myFriends->removeElement($myFriend);
            $myFriend->removeMyFriend($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFriendsWithMe(): Collection
    {
        return $this->friendsWithMe;
    }

    public function addFriendsWithMe(User $friendsWithMe): self
    {
        if (!$this->friendsWithMe->contains($friendsWithMe)) {
            $this->friendsWithMe[] = $friendsWithMe;
            $friendsWithMe->addFriendsWithMe($this);
        }

        return $this;
    }

    public function removeFriendsWithMe(User $friendsWithMe): self
    {
        if ($this->friendsWithMe->contains($friendsWithMe)) {
            $this->friendsWithMe->removeElement($friendsWithMe);
            $friendsWithMe->removeFriendsWithMe($this);
        }

        return $this;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos[] = $evento;
            $evento->setIdCreator($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->contains($evento)) {
            $this->eventos->removeElement($evento);
            // set the owning side to null (unless already changed)
            if ($evento->getIdCreator() === $this) {
                $evento->setIdCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventsJoined(): Collection
    {
        return $this->events_joined;
    }

    public function addEventsJoined(Evento $eventsJoined): self
    {
        if (!$this->events_joined->contains($eventsJoined)) {
            $this->events_joined[] = $eventsJoined;
        }

        return $this;
    }

    public function removeEventsJoined(Evento $eventsJoined): self
    {
        if ($this->events_joined->contains($eventsJoined)) {
            $this->events_joined->removeElement($eventsJoined);
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getInterests(): Collection
    {
        return $this->interests;
    }

    public function addInterest(Tag $interest): self
    {
        if (!$this->interests->contains($interest)) {
            $this->interests[] = $interest;
        }

        return $this;
    }

    public function removeInterest(Tag $interest): self
    {
        if ($this->interests->contains($interest)) {
            $this->interests->removeElement($interest);
        }

        return $this;
    }
}
