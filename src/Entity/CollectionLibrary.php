<?php

namespace App\Entity;

use App\Repository\CollectionLibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionLibraryRepository::class)]
class CollectionLibrary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $numberTome = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: GenreCollection::class, inversedBy: 'collectionLibraries')]
    private Collection $genreCollection;

    #[ORM\ManyToOne(inversedBy: 'collectionLibraries')]
    private ?CategoryCollection $categoryCollection = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModifie = null;

    #[ORM\OneToMany(mappedBy: 'collectionLibrary', targetEntity: TomeCollection::class, cascade: ["remove"])]
    private Collection $tomeCollections;

    #[ORM\OneToMany(mappedBy: 'collectionLibrary', targetEntity: CollectionUser::class, cascade: ["remove"])]
    private Collection $collectionUsers;

    #[ORM\OneToMany(mappedBy: 'collectionLibrary', targetEntity: TomeUser::class, cascade: ["remove"])]
    private Collection $tomeUsers;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $bgPicture = null;

    #[ORM\OneToMany(mappedBy: 'collectionLibrary', targetEntity: GroupTome::class, cascade: ["remove"])]
    private Collection $groupTomes;

    #[ORM\OneToMany(mappedBy: 'collectionLibrary', targetEntity: TomeUserRead::class, cascade: ["remove"])]
    private Collection $tomeUserReads;

    public function __construct()
    {
        $this->genreCollection = new ArrayCollection();
        $this->tomeCollections = new ArrayCollection();
        $this->collectionUsers = new ArrayCollection();
        $this->tomeUsers = new ArrayCollection();
        $this->groupTomes = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNumberTome(): ?int
    {
        return $this->numberTome;
    }

    public function setNumberTome(int $numberTome): static
    {
        $this->numberTome = $numberTome;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBgPicture(): ?string
    {
        return $this->bgPicture;
    }

    public function setBgPicture(string $bgPicture): static
    {
        $this->bgPicture = $bgPicture;

        return $this;
    }

    /**
     * @return Collection<int, GenreCollection>
     */
    public function getGenreCollection(): Collection
    {
        return $this->genreCollection;
    }

    public function addGenreCollection(GenreCollection $genreCollection): static
    {
        if (!$this->genreCollection->contains($genreCollection)) {
            $this->genreCollection->add($genreCollection);
        }

        return $this;
    }

    public function removeGenreCollection(GenreCollection $genreCollection): static
    {
        $this->genreCollection->removeElement($genreCollection);

        return $this;
    }

    public function getCategoryCollection(): ?CategoryCollection
    {
        return $this->categoryCollection;
    }

    public function setCategoryCollection(?CategoryCollection $categoryCollection): static
    {
        $this->categoryCollection = $categoryCollection;

        return $this;
    }

    /**
     * @return Collection<int, TomeCollection>
     */
    public function getTomeCollections(): Collection
    {
        return $this->tomeCollections;
    }

    public function addTomeCollection(TomeCollection $tomeCollection): static
    {
        if (!$this->tomeCollections->contains($tomeCollection)) {
            $this->tomeCollections->add($tomeCollection);
            $tomeCollection->setCollectionLibrary($this);
        }

        return $this;
    }

    public function removeTomeCollection(TomeCollection $tomeCollection): static
    {
        if ($this->tomeCollections->removeElement($tomeCollection)) {
            // set the owning side to null (unless already changed)
            if ($tomeCollection->getCollectionLibrary() === $this) {
                $tomeCollection->setCollectionLibrary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CollectionUser>
     */
    public function getCollectionUsers(): Collection
    {
        return $this->collectionUsers;
    }

    public function addCollectionUser(CollectionUser $collectionUser): static
    {
        if (!$this->collectionUsers->contains($collectionUser)) {
            $this->collectionUsers->add($collectionUser);
            $collectionUser->setCollectionLibrary($this);
        }

        return $this;
    }

    public function removeCollectionUser(CollectionUser $collectionUser): static
    {
        if ($this->collectionUsers->removeElement($collectionUser)) {
            // set the owning side to null (unless already changed)
            if ($collectionUser->getCollectionLibrary() === $this) {
                $collectionUser->setCollectionLibrary(null);
            }
        }

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
            $tomeUser->setCollectionLibrary($this);
        }

        return $this;
    }

    public function removeTomeUser(TomeUser $tomeUser): static
    {
        if ($this->tomeUsers->removeElement($tomeUser)) {
            // set the owning side to null (unless already changed)
            if ($tomeUser->getCollectionLibrary() === $this) {
                $tomeUser->setCollectionLibrary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupTome>
     */
    public function getGroupTomes(): Collection
    {
        return $this->groupTomes;
    }

    public function addGroupTome(GroupTome $groupTome): static
    {
        if (!$this->groupTomes->contains($groupTome)) {
            $this->groupTomes->add($groupTome);
            $groupTome->setCollectionLibrary($this);
        }

        return $this;
    }

    public function removeGroupTome(GroupTome $groupTome): static
    {
        if ($this->groupTomes->removeElement($groupTome)) {
            // set the owning side to null (unless already changed)
            if ($groupTome->getCollectionLibrary() === $this) {
                $groupTome->setCollectionLibrary(null);
            }
        }

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
            $tomeUserRead->setCollectionLibrary($this);
        }

        return $this;
    }

    public function removeTomeUserRead(TomeUserRead $tomeUserRead): static
    {
        if ($this->tomeUserReads->removeElement($tomeUserRead)) {
            // set the owning side to null (unless already changed)
            if ($tomeUserRead->getCollectionLibrary() === $this) {
                $tomeUserRead->setCollectionLibrary(null);
            }
        }

        return $this;
    }

}
