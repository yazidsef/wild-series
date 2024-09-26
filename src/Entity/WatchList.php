<?php

namespace App\Entity;

use App\Repository\WatchListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchListRepository::class)]
class WatchList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Episode>
     */
    #[ORM\OneToMany(targetEntity: Episode::class, mappedBy: 'watchList')]
    private Collection $episode_id;

    #[ORM\Column]
    private ?bool $seen = null;

    #[ORM\Column(nullable: true)]
    private ?bool $adoré = null;


    public function __construct()
    {
        $this->episode_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodeId(): Collection
    {
        return $this->episode_id;
    }

    public function addEpisodeId(Episode $episodeId): static
    {
        if (!$this->episode_id->contains($episodeId)) {
            $this->episode_id->add($episodeId);
            $episodeId->setWatchList($this);
        }

        return $this;
    }

    public function removeEpisodeId(Episode $episodeId): static
    {
        if ($this->episode_id->removeElement($episodeId)) {
            // set the owning side to null (unless already changed)
            if ($episodeId->getWatchList() === $this) {
                $episodeId->setWatchList(null);
            }
        }

        return $this;
    }

    public function isSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): static
    {
        $this->seen = $seen;

        return $this;
    }

    public function isAdoré(): ?bool
    {
        return $this->adoré;
    }

    public function setAdoré(?bool $adoré): static
    {
        $this->adoré = $adoré;

        return $this;
    }


}
