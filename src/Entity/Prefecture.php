<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prefecture
 *
 * @ORM\Table(name="prefecture")
 * @ORM\Entity(repositoryClass="App\Repository\PrefectureRepository")
 */
class Prefecture
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

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="code_region", referencedColumnName="code", nullable=true)
     */
    private $region;

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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;

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
        $region = null;
        if($this->getRegion()){
            $region = [
                "code"=>$this->getRegion()->getCode(),
                "libelle"=>$this->getRegion()->getLibelle()
            ];
        }
        return [
            "code"=>$this->code,
            "libelle"=>$this->libelle,
            "region"=>$region
        ];
    }
}
