<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Season $season = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    private ?int $number = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    private ?string $synonpsis = null;

    #[ORM\ManyToOne(inversedBy: 'episode_id')]
    private ?WatchList $watchList = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'episode')]
    private Collection $comments;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 150)]
    private ?string $duration = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getSynonpsis(): ?string
    {
        return $this->synonpsis;
    }

    public function setSynonpsis(string $synonpsis): static
    {
        $this->synonpsis = $synonpsis;

        return $this;
    }

    public function getWatchList(): ?WatchList
    {
        return $this->watchList;
    }

    public function setWatchList(?WatchList $watchList): static
    {
        $this->watchList = $watchList;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setEpisode($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEpisode() === $this) {
                $comment->setEpisode(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
