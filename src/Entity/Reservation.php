<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bookAt = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $idProfile = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Discipline $idDiscipline = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: 'idReservation')]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setIdReservation($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getIdReservation() === $this) {
                $participant->setIdReservation(null);
            }
        }

        return $this;
    }
}
