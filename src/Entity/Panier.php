<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $idProfile = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isPaid = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeSessionId = null;

     /**
     * @var Collection<int, PanierDiscipline>
     */
    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: PanierDiscipline::class, cascade: ['persist', 'remove'])]
    private Collection $panierDisciplines;

    public function __construct()
    {
        $this->panierDisciplines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdProfile(): ?Profile
    {
        return $this->idProfile;
    }

    public function setIdProfile(?Profile $idProfile): static
    {
        $this->idProfile = $idProfile;

        return $this;
    }

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): static
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
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
            $panierDiscipline->setPanier($this);
        }

        return $this;
    }

    public function removeBasketProduct(PanierDiscipline $panierDiscipline): static
    {
        if ($this->panierDisciplines->removeElement($panierDiscipline)) {
            if ($panierDiscipline->getPanier() === $this) {
                $panierDiscipline->setPanier(null);
            }
        }

        return $this;
    }
    public function getTotalAmount(): float
    {
        $total = 0;
        foreach ($this->panierDisciplines as $panierDiscipline) {
            $total += $panierDiscipline->getDiscipline()->getPrix() * $panierDiscipline->getQuantity();
        }
        return $total;
    }
}
