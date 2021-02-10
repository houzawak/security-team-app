<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commune
 *
 * @ORM\Table(name="commune")
 * @ORM\Entity(repositoryClass="App\Repository\CommuneRepository")
 */
class Commune
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
     * @var Prefecture
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Prefecture")
     * @ORM\JoinColumn(name="code_prefecture", referencedColumnName="code", nullable=true)
     */
    private $prefecture;

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

    public function getPrefecture(): ?Prefecture
    {
        return $this->prefecture;
    }

    public function setPrefecture(Prefecture $prefecture): self
    {
        $this->prefecture = $prefecture;

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
        $prefecture = null;
        if($this->getPrefecture()){
            $prefecture = [
                "code"=>$this->getPrefecture()->getCode(),
                "libelle"=>$this->getPrefecture()->getLibelle()
            ];
        }
        return [
            "code"=>$this->code,
            "libelle"=>$this->libelle,
            "prefecture"=>$prefecture
        ];
    }
}
