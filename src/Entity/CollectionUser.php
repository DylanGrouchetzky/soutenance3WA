<?php

namespace App\Entity;

use App\Repository\CollectionUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionUserRepository::class)]
class CollectionUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'collectionUsers')]
    private ?CollectionLibrary $collectionLibrary = null;

    #[ORM\ManyToOne(inversedBy: 'collectionUsers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'collectionUsers')]
    private ?CategoryCollection $categoryCollection = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
}
