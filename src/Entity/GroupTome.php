<?php

namespace App\Entity;

use App\Repository\GroupTomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupTomeRepository::class)]
class GroupTome
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'groupTomes')]
    private ?CollectionLibrary $collectionLibrary = null;

    #[ORM\OneToMany(mappedBy: 'groupTome', targetEntity: TomeCollection::class, cascade: ["remove"])]
    private Collection $tomeCollection;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->tomeCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, TomeCollection>
     */
    public function getTomeCollection(): Collection
    {
        return $this->tomeCollection;
    }

    public function addTomeCollection(TomeCollection $tomeCollection): static
    {
        if (!$this->tomeCollection->contains($tomeCollection)) {
            $this->tomeCollection->add($tomeCollection);
            $tomeCollection->setGroupTome($this);
        }

        return $this;
    }

    public function removeTomeCollection(TomeCollection $tomeCollection): static
    {
        if ($this->tomeCollection->removeElement($tomeCollection)) {
            // set the owning side to null (unless already changed)
            if ($tomeCollection->getGroupTome() === $this) {
                $tomeCollection->setGroupTome(null);
            }
        }

        return $this;
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
