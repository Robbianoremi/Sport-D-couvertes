<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[Vich\Uploadable]

class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'profile', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $prenom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Regex('/^\+?[0-9\s\-\(\)]+$/')]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\Regex('/^\d{14}$/')]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domiciliation = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex('/^\+?[0-9\s\-\(\)]+$/')]
    private ?string $telephone = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;
   
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'idProfile')]
    private Collection $reservations;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'idProfile')]
    private Collection $commentaires;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $bio = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'idProfile')]
    private Collection $paniers;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;   


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getDomiciliation(): ?string
    {
        return $this->domiciliation;
    }

    public function setDomiciliation(string $domiciliation): self
    {
        $this->domiciliation = $domiciliation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setIdProfile($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getIdProfile() === $this) {
                $reservation->setIdProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setIdProfile($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdProfile() === $this) {
                $commentaire->setIdProfile(null);
            }
        }

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenom;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setIdProfile($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getIdProfile() === $this) {
                $panier->setIdProfile(null);
            }
        }

        return $this;
    }

    public function __sleep()
{
    // Liste des propriétés à sérialiser
    return [
        'id',
        'nom',
        'prenom',
        'status',
        'nomEntreprise',
        'siret',
        'domiciliation',
        'telephone',
        'sexe',
        'bio',
        'updatedAt',
        'imageFile',
        'imageName',
        // Ajoutez d'autres propriétés si nécessaire
    ];
}

public function __wakeup()
{
    // Initialisation de certaines propriétés après la désérialisation si nécessaire
    if ($this->updatedAt === null) {
        $this->updatedAt = new \DateTimeImmutable(); // Initialisation de updatedAt si null
    }
    // Autres initialisations si nécessaires
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

}


