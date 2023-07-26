<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Controller\CreateEventController;
use App\Controller\GetEventController;
use App\Controller\GetEventsController;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Post(inputFormats: ['multipart' => ['multipart/form-data']], controller: CreateEventController::class),
        new Get(controller: GetEventController::class),
        new Delete(),
        new Put(),
        new GetCollection(controller: GetEventsController::class),
    ],
    normalizationContext: ['groups' => ['event:read']],
    denormalizationContext: ['groups' => ['event:write']]
)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
                'event:read',
                'get:collection:event',
                'category:read'
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
                'event:read',
                'event:write',
                'category:read'
            ]
    )]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups([
                'event:read',
                'event:write',
                'get:collection:event:normalization',
                'get:collection:event:denormalization'
            ]
    )]
    #[Assert\NotBlank]
    #[Assert\Length(min: 0, max: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'float', precision: 6, scale: 2)]
    #[Groups([
                'event:read',
                'event:write',
                'get:collection:event:normalization',
                'get:collection:event:denormalization'
            ])
    ]
    #[Assert\NotBlank]
    #[Assert\Range(min: -180, max: 180)]
    private ?float $longitude = null;

    #[ORM\Column(type: "float", precision: 6, scale: 2)]
    #[Groups(
        [
            'event:read',
            'event:write',
        ]
    )]
    #[Assert\NotBlank]
    #[Assert\Range(min: -180, max: 180)]
    private ?float $latitude = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(
        [
            'event:read',
            'get:collection:event:normalization',
            'get:collection:event:denormalization'
        ]
    )]
    private ?Feed $feed = null;

    #[Vich\UploadableField(mapping: 'event_cover', fileNameProperty: 'coverPath')]
    #[Groups(
        [
            'event:read'
        ]
    )]
    public ?File $coverFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(
        [
            'event:read',
        ]
    )]
    private ?string $coverPath = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(
        [
            'event:read'
        ]
    )]
    public ?string $coverUrl = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Participation::class, orphanRemoval: true)]
    #[Groups(
        [
            'event:read'
        ]
    )]
    private Collection $participations;

    #[ORM\ManyToOne(inversedBy: 'event')]
    #[Groups(
        [
            'event:read'
        ]
    )]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'event:read'
        ]
    )]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Groups(
        [
            'event:read',
            'event:write'
        ]
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(
        [
            'event:read'
        ]
    )]
    private ?int $maxParticipationNumber = 10;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

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

    public function getCoverPath(): ?string
    {
        return $this->coverPath;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function getParticipationsNumber(): int
    {
        return $this->participations->count();
    }

    /**
     * @param string|null $coverPath
     */
    public function setCoverPath(?string $coverPath): void
    {
        $this->coverPath = $coverPath;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setEvent($this);
        }


        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }


    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEvent() === $this) {
                $participation->setEvent(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMaxParticipationNumber(): ?int
    {
        return $this->maxParticipationNumber;
    }

    public function setMaxParticipationNumber(int $maxParticipationNumber): self
    {
        $this->maxParticipationNumber = $maxParticipationNumber;

        return $this;
    }


}
