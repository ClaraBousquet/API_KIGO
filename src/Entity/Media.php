<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ApiResource]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'Media')]
    private ?Post $posts = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPosts(): ?Post
    {
        return $this->posts;
    }

    public function setPosts(?Post $posts): static
    {
        $this->posts = $posts;

        return $this;
    }


}
