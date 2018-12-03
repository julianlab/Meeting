<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincias
 *
 * @ORM\Table(name="provincias", uniqueConstraints={@ORM\UniqueConstraint(name="IDX_provincia", columns={"provincia"})}, indexes={@ORM\Index(name="FK_provincias", columns={"comunidad_id"})})
 * @ORM\Entity
 */
class Provincias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=70, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=70, nullable=false)
     */
    private $provincia;

    /**
     * @var int
     *
     * @ORM\Column(name="comunidad_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $comunidadId;

    /**
     * @var int
     *
     * @ORM\Column(name="capital_id", type="integer", nullable=false, options={"default"="-1"})
     */
    private $capitalId = '-1';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getProvincia(): string
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     */
    public function setProvincia(string $provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return int
     */
    public function getComunidadId(): int
    {
        return $this->comunidadId;
    }

    /**
     * @param int $comunidadId
     */
    public function setComunidadId(int $comunidadId)
    {
        $this->comunidadId = $comunidadId;
    }

    /**
     * @return int
     */
    public function getCapitalId(): int
    {
        return $this->capitalId;
    }

    /**
     * @param int $capitalId
     */
    public function setCapitalId(int $capitalId)
    {
        $this->capitalId = $capitalId;
    }


}
