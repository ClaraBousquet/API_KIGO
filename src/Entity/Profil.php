<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
#[ApiResource]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $fillière = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bio = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFillière(): ?int
    {
        return $this->fillière;
    }

    public function setFillière(?int $fillière): static
    {
        $this->fillière = $fillière;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }


}
