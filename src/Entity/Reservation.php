<?php

namespace App\Entity;

use App\Entity\Profile;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;


#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $idProfile = null;

    #[ORM\ManyToOne(inversedBy: 'reservation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Discipline $idDiscipline = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bookAt = null;

    #[ORM\Column]
    private ?int $nbrPers = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdDiscipline(): ?Discipline
    {
        return $this->idDiscipline;
    }

    public function setIdDiscipline(?Discipline $idDiscipline): static
    {
        $this->idDiscipline = $idDiscipline;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBookAt(): ?\DateTimeImmutable
    {
        return $this->bookAt;
    }

    public function setBookAt(\DateTimeImmutable $bookAt): static
    {
        $this->bookAt = $bookAt;

        return $this;
    }

    public function getNbrPers(): ?int
    {
        return $this->nbrPers;
    }

    public function setNbrPers(int $nbrPers): static
    {
        $this->nbrPers = $nbrPers;

        return $this;
    }
}
