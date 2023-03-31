<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FeedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedRepository::class)]
#[ApiResource]
class Feed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'feed', targetEntity: FeedPost::class, orphanRemoval: true)]
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
}
