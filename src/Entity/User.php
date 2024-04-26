<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["user:read"]],
    denormalizationContext: ["groups" => ["user:write"]]
) ]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{


    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
     #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["user:read", "user:write"]) ]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
     #[Groups([ 'user:write'])]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Profil $profil = null;

     #[Groups(['user:read'])]
     #[ORM\Column(length: 255, nullable: true)]
     private ?string $nickname = null;

     #[Groups(['user:read', 'user:write'])]
     #[ORM\ManyToOne(inversedBy: 'user')]
     private ?Filiere $filiere = null;

     #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'users')]
         #[Groups(["user:read", "user:write"]) ]
     private Collection $skills;

     #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["user:read", "user:write"]) ]

     private ?string $biography = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->skills = new ArrayCollection();
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
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
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): static
    {
        $this->profil = $profil;

        return $this;
    }

     public function getNickname(): ?string
    {
         return $this->nickname;
     }

     public function setNickname(?string $nickname): static
     {
        $this->nickname = $nickname;

         return $this;
     }

     public function getFiliere(): ?Filiere
     {
         return $this->filiere;
     }

     public function setFiliere(?Filiere $filiere): static
     {
         $this->filiere = $filiere;

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

     public function getBiography(): ?string
     {
         return $this->biography;
     }

     public function setBiography(?string $biography): static
     {
         $this->biography = $biography;

         return $this;
     }
}
