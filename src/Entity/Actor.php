<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeImmutable $birth_date = null;

    /**
     * @var Collection<int, Program>
     */
    #[ORM\ManyToMany(targetEntity: Program::class, inversedBy: 'actors')]
    private Collection $Programs;

    public function __construct()
    {
        $this->Programs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeImmutable $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->Programs;
    }

    public function addProgram(Program $program): static
    {
        if (!$this->Programs->contains($program)) {
            $this->Programs->add($program);
        }

        return $this;
    }

    public function removeProgram(Program $program): static
    {
        $this->Programs->removeElement($program);

        return $this;
    }
}
