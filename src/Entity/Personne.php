<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Personne extends  BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nom", type="string", length=150, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenoms", type="string", length=150, nullable=false)
     */
    private $prenoms;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=50, nullable=true)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=50, nullable=true)
     */
    private $grade;

    /**
     * @var Camp
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp")
     * @ORM\JoinColumn(name="code_camp", referencedColumnName="code")
     */
    private $campAffectation;

    /**
     * @ORM\Column(name="photo", type="string", nullable=true))
     */
    private $photo;

    /**
     * @ORM\Column(name="position", type="integer", nullable=true))
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function __toString()
    {
        return $this->nom." ".$this->prenoms;
    }

    public function toArray()
    {
        $campAffectation = null;
        if($this->getCampAffectation()){
            $campAffectation = [
                "code"=>$this->getCampAffectation()->getCode(),
                "libelle"=>$this->getCampAffectation()->getLibelle()
            ];
        }
        return [
            "id"=>$this->id,
            "nom"=>$this->nom,
            "prenoms"=>$this->prenoms,
            "poste"=>$this->poste,
            "grade"=>$this->grade,
            "campAffectation"=>$campAffectation,
            "photo"=>$this->photo,
            "position"=>$this->position
        ];
    }

    public function getCampAffectation(): ?Camp
    {
        return $this->campAffectation;
    }

    public function setCampAffectation(?Camp $campAffectation): self
    {
        $this->campAffectation = $campAffectation;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
