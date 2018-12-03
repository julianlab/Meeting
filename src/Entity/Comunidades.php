<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comunidades
 *
 * @ORM\Table(name="comunidades", uniqueConstraints={@ORM\UniqueConstraint(name="PK_comunidad", columns={"comunidad"}), @ORM\UniqueConstraint(name="slug", columns={"slug"})})
 * @ORM\Entity
 */
class Comunidades
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
     * @ORM\Column(name="slug", type="string", length=50, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="comunidad", type="string", length=50, nullable=false)
     */
    private $comunidad;

    /**
     * @var int
     *
     * @ORM\Column(name="capital_id", type="integer", nullable=false)
     */
    private $capitalId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
    public function getComunidad(): string
    {
        return $this->comunidad;
    }

    /**
     * @param string $comunidad
     */
    public function setComunidad(string $comunidad)
    {
        $this->comunidad = $comunidad;
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
