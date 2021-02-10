<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Camp
 *
 * @ORM\Table(name="camp")
 * @ORM\Entity(repositoryClass="App\Repository\CampRepository")
 */
class Camp
{
    /**
     * @var string
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
     * @var Ville
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville")
     * @ORM\JoinColumn(name="code_ville", referencedColumnName="code")
     */
    private $ville;

    /**
     * @var TypeCamp
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeCamp")
     * @ORM\JoinColumn(name="code_type_camp", referencedColumnName="code")
     */
    private $typeCamp;
    

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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTypeCamp(): ?TypeCamp
    {
        return $this->typeCamp;
    }

    public function setTypeCamp(?TypeCamp $typeCamp): self
    {
        $this->typeCamp = $typeCamp;

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
        $ville = [
            "code"=>$this->getVille()->getCode(),
            "libelle"=>$this->getVille()->getLibelle(),
        ];

        return [
            "code"=>$this->code,
            "libelle"=>$this->libelle,
            "ville"=>$ville
        ];
    }
}
