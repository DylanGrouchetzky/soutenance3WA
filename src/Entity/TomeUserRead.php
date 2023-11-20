<?php

namespace App\Entity;

use App\Repository\TomeUserReadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TomeUserReadRepository::class)]
class TomeUserRead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tomeUserReads')]
    private ?TomeCollection $nameTome = null;

    #[ORM\ManyToOne(inversedBy: 'tomeUserReads')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'tomeUserReads')]
    private ?CollectionLibrary $collectionLibrary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTome(): ?TomeCollection
    {
        return $this->nameTome;
    }

    public function setNameTome(?TomeCollection $nameTome): static
    {
        $this->nameTome = $nameTome;

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

    public function getCollectionLibrary(): ?CollectionLibrary
    {
        return $this->collectionLibrary;
    }

    public function setCollectionLibrary(?CollectionLibrary $collectionLibrary): static
    {
        $this->collectionLibrary = $collectionLibrary;

        return $this;
    }
}
