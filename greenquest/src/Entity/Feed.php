<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\FeedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FeedRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new GetCollection()
], normalizationContext: ['groups' => ['feed:read']])]
class Feed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['feed:read'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'feed', targetEntity: FeedPost::class, orphanRemoval: true)]
    #[Groups('feed:read')]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, FeedPost>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(FeedPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setFeed($this);
        }

        return $this;
    }

    public function removePost(FeedPost $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getFeed() === $this) {
                $post->setFeed(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'Feed#' . $this->id;
    }
}
