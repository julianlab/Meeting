<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAdminRepository")
 */
class UserAdmin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $role_admin;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    public function getId()
    {
        return $this->id;
    }

    public function getRoleAdmin(): ?int
    {
        return $this->role_admin;
    }

    public function setRoleAdmin(int $role_admin): self
    {
        $this->role_admin = $role_admin;

        return $this;
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
}
