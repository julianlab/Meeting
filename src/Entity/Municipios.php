<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Municipios
 *
 * @ORM\Table(name="municipios", uniqueConstraints={@ORM\UniqueConstraint(name="IDX_municipio", columns={"provincia_id", "municipio"}), @ORM\UniqueConstraint(name="slug", columns={"slug"})})
 * @ORM\Entity
 */
class Municipios
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
     * @var int
     *
     * @ORM\Column(name="provincia_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $provinciaId;

    /**
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=70, nullable=false)
     */
    private $municipio;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=70, nullable=false)
     */
    private $slug;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitud", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitud;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitud", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitud;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return int
     */
    public function getProvinciaId(): int
    {
        return $this->provinciaId;
    }

    /**
     * @param int $provinciaId
     */
    public function setProvinciaId(int $provinciaId)
    {
        $this->provinciaId = $provinciaId;
    }

    /**
     * @return string
     */
    public function getMunicipio(): string
    {
        return $this->municipio;
    }

    /**
     * @param string $municipio
     */
    public function setMunicipio(string $municipio)
    {
        $this->municipio = $municipio;
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
     * @return float|null
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param float|null $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * @return float|null
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param float|null $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }


}
