<?php

namespace App\Entity;

use App\Repository\ParameterWebsiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterWebsiteRepository::class)]
class ParameterWebsite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameWebsite = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imgHeroSectionHome = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $logoWebsite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $linkFacebook = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $linkInstagram = null;

    #[ORM\Column(length: 255)]
    private ?string $emailContact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textDetailWebsite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameWebsite(): ?string
    {
        return $this->nameWebsite;
    }

    public function setNameWebsite(string $nameWebsite): static
    {
        $this->nameWebsite = $nameWebsite;

        return $this;
    }

    public function getImgHeroSectionHome(): ?string
    {
        return $this->imgHeroSectionHome;
    }

    public function setImgHeroSectionHome(?string $imgHeroSectionHome): static
    {
        $this->imgHeroSectionHome = $imgHeroSectionHome;

        return $this;
    }

    public function getLogoWebsite(): ?string
    {
        return $this->logoWebsite;
    }

    public function setLogoWebsite(?string $logoWebsite): static
    {
        $this->logoWebsite = $logoWebsite;

        return $this;
    }

    public function getLinkFacebook(): ?string
    {
        return $this->linkFacebook;
    }

    public function setLinkFacebook(?string $linkFacebook): static
    {
        $this->linkFacebook = $linkFacebook;

        return $this;
    }

    public function getLinkInstagram(): ?string
    {
        return $this->linkInstagram;
    }

    public function setLinkInstagram(?string $linkInstagram): static
    {
        $this->linkInstagram = $linkInstagram;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): static
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getTextDetailWebsite(): ?string
    {
        return $this->textDetailWebsite;
    }

    public function setTextDetailWebsite(string $textDetailWebsite): static
    {
        $this->textDetailWebsite = $textDetailWebsite;

        return $this;
    }
}
