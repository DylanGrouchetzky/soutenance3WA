<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cette adresse mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CollectionUser::class, cascade: ["remove"])]
    private Collection $collectionUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TomeUser::class, cascade: ["remove"])]
    private Collection $tomeUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TomeUserRead::class, cascade: ["remove"])]
    private Collection $tomeUserReads;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastConnect = null;

    public function __construct()
    {
        $this->collectionUsers = new ArrayCollection();
        $this->tomeUsers = new ArrayCollection();
        $this->tomeUserReads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $collectionUser->setUser($this);
        }

        return $this;
    }

    public function removeCollectionUser(CollectionUser $collectionUser): static
    {
        if ($this->collectionUsers->removeElement($collectionUser)) {
            // set the owning side to null (unless already changed)
            if ($collectionUser->getUser() === $this) {
                $collectionUser->setUser(null);
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
            $tomeUser->setUser($this);
        }

        return $this;
    }

    public function removeTomeUser(TomeUser $tomeUser): static
    {
        if ($this->tomeUsers->removeElement($tomeUser)) {
            // set the owning side to null (unless already changed)
            if ($tomeUser->getUser() === $this) {
                $tomeUser->setUser(null);
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
            $tomeUserRead->setUser($this);
        }

        return $this;
    }

    public function removeTomeUserRead(TomeUserRead $tomeUserRead): static
    {
        if ($this->tomeUserReads->removeElement($tomeUserRead)) {
            // set the owning side to null (unless already changed)
            if ($tomeUserRead->getUser() === $this) {
                $tomeUserRead->setUser(null);
            }
        }

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): static
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getLastConnect(): ?\DateTimeInterface
    {
        return $this->lastConnect;
    }

    public function setLastConnect(?\DateTimeInterface $lastConnect): static
    {
        $this->lastConnect = $lastConnect;

        return $this;
    }
}
