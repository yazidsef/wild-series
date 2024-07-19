<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Season $season_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $synonpsis = null;

    #[ORM\ManyToOne(inversedBy: 'episode_id')]
    private ?WatchList $watchList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeasonId(): ?Season
    {
        return $this->season_id;
    }

    public function setSeasonId(?Season $season_id): static
    {
        $this->season_id = $season_id;

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
}
