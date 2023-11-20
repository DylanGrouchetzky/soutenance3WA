<?php

namespace App\Entity;

use App\Repository\CategoryCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryCollectionRepository::class)]
class CategoryCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModifie = null;

    #[ORM\OneToMany(mappedBy: 'categoryCollection', targetEntity: GenreCollection::class, cascade: ["remove"])]
    private Collection $genreCollections;

    #[ORM\OneToMany(mappedBy: 'categoryCollection', targetEntity: CollectionLibrary::class, cascade: ["remove"])]
    private Collection $collectionLibraries;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'categoryCollection', targetEntity: CollectionUser::class, cascade: ["remove"])]
    private Collection $collectionUsers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    public function __construct()
    {
        $this->genreCollections = new ArrayCollection();
        $this->collectionLibraries = new ArrayCollection();
        $this->collectionUsers = new ArrayCollection();
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

    /**
     * @return Collection<int, GenreCollection>
     */
    public function getGenreCollections(): Collection
    {
        return $this->genreCollections;
    }

    public function addGenreCollection(GenreCollection $genreCollection): static
    {
        if (!$this->genreCollections->contains($genreCollection)) {
            $this->genreCollections->add($genreCollection);
            $genreCollection->setCategoryCollection($this);
        }

        return $this;
    }

    public function removeGenreCollection(GenreCollection $genreCollection): static
    {
        if ($this->genreCollections->removeElement($genreCollection)) {
            // set the owning side to null (unless already changed)
            if ($genreCollection->getCategoryCollection() === $this) {
                $genreCollection->setCategoryCollection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CollectionLibrary>
     */
    public function getCollectionLibraries(): Collection
    {
        return $this->collectionLibraries;
    }

    public function addCollectionLibrary(CollectionLibrary $collectionLibrary): static
    {
        if (!$this->collectionLibraries->contains($collectionLibrary)) {
            $this->collectionLibraries->add($collectionLibrary);
            $collectionLibrary->setCategoryCollection($this);
        }

        return $this;
    }

    public function removeCollectionLibrary(CollectionLibrary $collectionLibrary): static
    {
        if ($this->collectionLibraries->removeElement($collectionLibrary)) {
            // set the owning side to null (unless already changed)
            if ($collectionLibrary->getCategoryCollection() === $this) {
                $collectionLibrary->setCategoryCollection(null);
            }
        }

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
            $collectionUser->setCategoryCollection($this);
        }

        return $this;
    }

    public function removeCollectionUser(CollectionUser $collectionUser): static
    {
        if ($this->collectionUsers->removeElement($collectionUser)) {
            // set the owning side to null (unless already changed)
            if ($collectionUser->getCategoryCollection() === $this) {
                $collectionUser->setCategoryCollection(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }
}
