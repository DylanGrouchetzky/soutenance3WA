<?php

namespace App\Entity;

use App\Repository\TomeCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TomeCollectionRepository::class)]
class TomeCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tomeCollections')]
    private ?CollectionLibrary $collectionLibrary = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModifie = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'nameTome', targetEntity: TomeUser::class, cascade: ["remove"])]
    private Collection $tomeUsers;

    #[ORM\ManyToOne(inversedBy: 'tomeCollection')]
    private ?GroupTome $groupTome = null;

    #[ORM\OneToMany(mappedBy: 'nameTome', targetEntity: TomeUserRead::class, cascade: ["remove"])]
    private Collection $tomeUserReads;

    public function __construct()
    {
        $this->tomeUsers = new ArrayCollection();
        $this->tomeUserReads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCollectionLibrary(): ?CollectionLibrary
    {
        return $this->collectionLibrary;
    }

    public function setCollectionLibrary(?CollectionLibrary $collectionLibrary): static
    {
        $this->collectionLibrary = $collectionLibrary;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): static
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateModifie(): ?\DateTimeInterface
    {
        return $this->dateModifie;
    }

    public function setDateModifie(\DateTimeInterface $dateModifie): static
    {
        $this->dateModifie = $dateModifie;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, TomeUser>
     */
    public function getTomeUsers(): Collection
    {
        return $this->tomeUsers;
    }

    public function addTomeUser(TomeUser $tomeUser): static
    {
        if (!$this->tomeUsers->contains($tomeUser)) {
            $this->tomeUsers->add($tomeUser);
            $tomeUser->setNameTome($this);
        }

        return $this;
    }

    public function removeTomeUser(TomeUser $tomeUser): static
    {
        if ($this->tomeUsers->removeElement($tomeUser)) {
            // set the owning side to null (unless already changed)
            if ($tomeUser->getNameTome() === $this) {
                $tomeUser->setNameTome(null);
            }
        }

        return $this;
    }

    public function getGroupTome(): ?GroupTome
    {
        return $this->groupTome;
    }

    public function setGroupTome(?GroupTome $groupTome): static
    {
        $this->groupTome = $groupTome;

        return $this;
    }

    /**
     * @return Collection<int, TomeUserRead>
     */
    public function getTomeUserReads(): Collection
    {
        return $this->tomeUserReads;
    }

    public function addTomeUserRead(TomeUserRead $tomeUserRead): static
    {
        if (!$this->tomeUserReads->contains($tomeUserRead)) {
            $this->tomeUserReads->add($tomeUserRead);
            $tomeUserRead->setNameTome($this);
        }

        return $this;
    }

    public function removeTomeUserRead(TomeUserRead $tomeUserRead): static
    {
        if ($this->tomeUserReads->removeElement($tomeUserRead)) {
            // set the owning side to null (unless already changed)
            if ($tomeUserRead->getNameTome() === $this) {
                $tomeUserRead->setNameTome(null);
            }
        }

        return $this;
    }
}
