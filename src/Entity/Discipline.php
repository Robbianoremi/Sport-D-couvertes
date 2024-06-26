<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: DisciplineRepository::class)]
class Discipline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotBlank]
    private ?string $detail = null;

     /**
     * @var Collection<int, PanierDiscipline>
     */
    #[ORM\OneToMany(mappedBy: 'discipline', targetEntity: PanierDiscipline::class, cascade: ['persist', 'remove'])]
    private Collection $panierDisciplines;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'idDiscipline')]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'disciplines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $idActivite = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'idDiscipline')]
    private Collection $commentaires;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->panierDisciplines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    
    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setIdDiscipline($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getIdDiscipline() === $this) {
                $reservation->setIdDiscipline(null);
            }
        }

        return $this;
    }

    public function getIdActivite(): ?Activite
    {
        return $this->idActivite;
    }

    public function setIdActivite(?Activite $idActivite): static
    {
        $this->idActivite = $idActivite;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setIdDiscipline($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdDiscipline() === $this) {
                $commentaire->setIdDiscipline(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }

     /**
     * @return Collection<int, PanierDiscipline>
     */
    public function getPanierDisciplines(): Collection
    {
        return $this->panierDisciplines;
    }

    public function addPanierDiscipline(PanierDiscipline $panierDiscipline): static
    {
        if (!$this->panierDisciplines->contains($panierDiscipline)) {
            $this->panierDisciplines->add($panierDiscipline);
            $panierDiscipline->setDiscipline($this);
        }

        return $this;
    }

    public function removePanierDiscipline(PanierDiscipline $panierDiscipline): static
    {
        if ($this->panierDisciplines->removeElement($panierDiscipline)) {
            if ($panierDiscipline->getDiscipline() === $this) {
                $panierDiscipline->setDiscipline(null);
            }
        }

        return $this;
    }
}
