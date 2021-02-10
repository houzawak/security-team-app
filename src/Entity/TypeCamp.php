<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeCamp
 *
 * @ORM\Table(name="type_camp")
 * @ORM\Entity()
 */
class TypeCamp
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=30, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=150, nullable=false)
     */
    private $libelle;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "code"=>$this->code,
            "libelle"=>$this->libelle
        ];
    }
}
