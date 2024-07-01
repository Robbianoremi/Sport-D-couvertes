<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
   
    private ?string $detail = null;

    /**
     * @var Collection<int, Discipline>
     */
    #[ORM\OneToMany(targetEntity: Discipline::class, mappedBy: 'idActivite')]
    private Collection $disciplines;

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
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

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): static
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines->add($discipline);
            $discipline->setIdActivite($this);
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): static
    {
        if ($this->disciplines->removeElement($discipline)) {
            // set the owning side to null (unless already changed)
            if ($discipline->getIdActivite() === $this) {
                $discipline->setIdActivite(null);
            }
        }

        return $this;
    }
}
