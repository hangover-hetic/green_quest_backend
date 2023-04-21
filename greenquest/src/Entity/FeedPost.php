<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateFeedPostController;
use App\Repository\FeedPostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: FeedPostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new Post(inputFormats: ['multipart' => ['multipart/form-data']]),
        new Delete()
    ],
    normalizationContext: ['groups' => ['feed_post:read']],
    denormalizationContext: ['groups' => ['feed_post:write']],
)
]
#[Vich\Uploadable]
class FeedPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['feed:read', 'feed_post:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['feed:read', 'feed_post:read', 'feed_post:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['feed:read', 'feed_post:read', 'feed_post:write'])]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['feed:read', 'feed_post:read', 'feed_post:write'])]
    private ?Feed $feed = null;

    #[ORM\Column]
    #[Groups(['feed:read', 'feed_post:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['feed:read', 'feed_post:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'feedPosts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['feed:read', 'feed_post:read', 'feed_post:write'])]
    private ?User $author = null;


    #[Vich\UploadableField(mapping: 'feed_post_cover', fileNameProperty: 'coverPath')]
    #[Groups(['feed_post:write'])]
    public ?File $coverFile = null;


    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['feed:read', 'feed_post:read'])]
    public ?string $coverUrl = null;

    #[ORM\Column(nullable: true)]
    private ?string $coverPath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFeed(): ?Feed
    {
        return $this->feed;
    }

    public function setFeed(?Feed $feed): self
    {
        $this->feed = $feed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTimeImmutable('now'));
        }
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }

    public function setCoverUrl(string $coverUrl): self
    {
        $this->coverUrl = $coverUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoverPath(): ?string
    {
        return $this->coverPath;
    }

    /**
     * @param string|null $coverPath
     */
    public function setCoverPath(?string $coverPath): void
    {
        $this->coverPath = $coverPath;
    }
}
