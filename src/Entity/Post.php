<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['post:read']],
    denormalizationContext: ['groups' => ['post:write']],
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['post:read', 'post:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;


    #[Groups(['post:read', 'post:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[Groups(['post:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

  

   

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'posts', targetEntity: Media::class)]
    private Collection $Media;

    #[ORM\OneToOne(mappedBy: 'post', cascade: ['persist', 'remove'])]
    private ?Project $project = null;

    #[ORM\Column(nullable: true)]
    private ?int $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_path = null;

    #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'posts')]
    private Collection $skills;

    public function __construct()
    {
        $this->Media = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->Media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->Media->contains($medium)) {
            $this->Media->add($medium);
            $medium->setPosts($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->Media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getPosts() === $this) {
                $medium->setPosts(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        // unset the owning side of the relation if necessary
        if ($project === null && $this->project !== null) {
            $this->project->setPost(null);
        }

        // set the owning side of the relation if necessary
        if ($project !== null && $project->getPost() !== $this) {
            $project->setPost($this);
        }

        $this->project = $project;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): static
    {
        $this->image_path = $image_path;

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }


}
