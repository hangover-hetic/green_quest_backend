<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\MeCrudController;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    operations: [
        new Get(controller: MeCrudController::class, uriTemplate: '/me', read: false),
        new Post(),
        new Delete(),
        new Put(),
        new GetCollection(),

    ],
)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('feed:read')]
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

    #[ORM\Column(length: 255)]
    #[Groups('feed:read')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups('feed:read')]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?int $exp = null;

    #[ORM\Column]
    private ?int $blobs = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: FeedPost::class)]
    private Collection $feedPosts;

    public function __construct()
    {
        $this->feedPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getExp(): ?int
    {
        return $this->exp;
    }

    public function setExp(?int $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getBlobs(): ?int
    {
        return $this->blobs;
    }

    public function setBlobs(int $blobs): self
    {
        $this->blobs = $blobs;

        return $this;
    }

    /**
     * @return Collection<int, FeedPost>
     */
    public function getFeedPosts(): Collection
    {
        return $this->feedPosts;
    }

    public function addFeedPost(FeedPost $feedPost): self
    {
        if (!$this->feedPosts->contains($feedPost)) {
            $this->feedPosts->add($feedPost);
            $feedPost->setAuthor($this);
        }

        return $this;
    }

    public function removeFeedPost(FeedPost $feedPost): self
    {
        if ($this->feedPosts->removeElement($feedPost)) {
            // set the owning side to null (unless already changed)
            if ($feedPost->getAuthor() === $this) {
                $feedPost->setAuthor(null);
            }
        }

        return $this;
    }
}
