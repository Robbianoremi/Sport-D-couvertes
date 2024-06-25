<?php

namespace App\Entity;

use App\Repository\PanierDisciplineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierDisciplineRepository::class)]
class PanierDiscipline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'PanierDisciplines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Panier $panier = null;

    #[ORM\ManyToOne(targetEntity: Discipline::class, inversedBy: 'PanierDisciplines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Discipline $discipline = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): static
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}