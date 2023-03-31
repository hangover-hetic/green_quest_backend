<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Delete(),
        new Put(),
        new GetCollection()
    ],normalizationContext: ['groups' => ['event:read']]
)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('event:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('event:read')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('event:read')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups('event:read')]
    private ?float $longitude = null;

    #[ORM\Column]
    #[Groups('event:read')]
    private ?float $latitude = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups('event:read')]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

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
