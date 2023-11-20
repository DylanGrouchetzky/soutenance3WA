<?php

namespace App\Entity;

use App\Repository\GenreCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreCollectionRepository::class)]
class GenreCollection
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

    #[ORM\ManyToOne(inversedBy: 'genreCollections')]
    private ?CategoryCollection $categoryCollection = null;

    #[ORM\ManyToMany(targetEntity: CollectionLibrary::class, mappedBy: 'genreCollection')]
    private Collection $collectionLibraries;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->collectionLibraries = new ArrayCollection();
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
            $collectionLibrary->addGenreCollection($this);
        }

        return $this;
    }

    public function removeCollectionLibrary(CollectionLibrary $collectionLibrary): static
    {
        if ($this->collectionLibraries->removeElement($collectionLibrary)) {
            $collectionLibrary->removeGenreCollection($this);
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
}
