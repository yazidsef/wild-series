<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
#[Vich\Uploadable] //on ajoute cette annotation pour dire que cette entité est liée à un fichier
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Ne laissez pas ce champ vide')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    //on peut pas ajouter plus belle la vie 
    #[Assert\NotEqualTo(value: 'plus belle la vie', message: 'On parle de vraies séries')]
    private ?string $synopsis = null;

    //poster pour stocker le nom du fichier
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]

    private ?string $poster = null;

    //on ajoute cette propriété pour stocker le fichier
    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'poster')]
    private ?File $posterFile = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    private ?string $country = null;

    #[ORM\ManyToOne(inversedBy: 'programs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank (message: 'Ne laissez pas ce champ vide')]
    private ?Category $category = null;

    /**
     * @var Collection<int, Season>
     */
    #[ORM\OneToMany(targetEntity: Season::class, mappedBy: 'program', orphanRemoval: true)]
    private Collection $seasons;
    /**
     * @var Collection<int, Actor>
     */
    #[ORM\ManyToMany(targetEntity: Actor::class, mappedBy: 'Programs')]
    private Collection $actors;

    #[ORM\Column(length: 150)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'programs')]
    private ?User $owner = null;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }
    public function setPosterFile(File $image = null): Program
{
   $this->posterFile = $image;
   return $this;
}

public function getPosterFile(): ?File
{
   return $this->posterFile;
}

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setprogram($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getprogram() === $this) {
                $season->setprogram(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
            $actor->addProgram($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        if ($this->actors->removeElement($actor)) {
            $actor->removeProgram($this);
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
