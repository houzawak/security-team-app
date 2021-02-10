<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville", indexes={@ORM\Index(name="code", columns={"code"})})
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=150, nullable=false)
     */
    private $libelle;

    /**
     * @var Commune
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Commune")
     * @ORM\JoinColumn(name="code_commune", referencedColumnName="code",nullable=true)
     */
    private $commune;

    public function getCode(): ?int
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

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(Commune $commune): self
    {
        $this->commune = $commune;

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
        $commune = null;
        if($this->getCommune()){
            $commune = [
                "code"=>$this->getCommune()->getCode(),
                "libelle"=>$this->getCommune()->getLibelle()
            ];
        }
        return [
            "code"=>$this->code,
            "libelle"=>$this->libelle,
            "commune"=>$commune
        ];
    }
}
