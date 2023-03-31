<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\FeedPostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FeedPostRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new Post(),
    new Delete()
])]
class FeedPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('feed:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('feed:read')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('feed:read')]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Feed $feed = null;

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
}
