<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Regex('/^\+?[0-9\s\-\(\)]+$/')]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[DateTime]
    protected string $createdAt;
    private ?\DateTimeInterface $date = null;

    #[Regex('/^\+?[0-9\s\-\(\)]+$/')]
    #[ORM\ManyToOne(inversedBy: 'commentaires')]

    #[ORM\JoinColumn(nullable: false)]
    private ?Discipline $idDiscipline = null;

    #[Regex('/^\+?[0-9\s\-\(\)]+$/')]
    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $idProfile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDatetime(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getIdDiscipline(): ?Discipline
    {
        return $this->idDiscipline;
    }

    public function setIdDiscipline(?Discipline $idDiscipline): static
    {
        $this->idDiscipline = $idDiscipline;

        return $this;
    }

    public function getIdProfile(): ?Profile
    {
        return $this->idProfile;
    }

    public function setIdProfile(?Profile $idProfile): static
    {
        $this->idProfile = $idProfile;

        return $this;
    }
}
