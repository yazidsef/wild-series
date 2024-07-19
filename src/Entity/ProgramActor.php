<?php

namespace App\Entity;

use App\Repository\ProgramActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramActorRepository::class)]
class ProgramActor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Actor $actor_id = null;

    /**
     * @var Collection<int, Program>
     */
    #[ORM\OneToMany(targetEntity: Program::class, mappedBy: 'programActor')]
    private Collection $program_id;

    public function __construct()
    {
        $this->program_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActorId(): ?Actor
    {
        return $this->actor_id;
    }

    public function setActorId(Actor $actor_id): static
    {
        $this->actor_id = $actor_id;

        return $this;
    }

    /**
     * @return Collection<int, Program>
     */
    public function getProgramId(): Collection
    {
        return $this->program_id;
    }

    public function addProgramId(Program $programId): static
    {
        if (!$this->program_id->contains($programId)) {
            $this->program_id->add($programId);
            $programId->setProgramActor($this);
        }

        return $this;
    }

    public function removeProgramId(Program $programId): static
    {
        if ($this->program_id->removeElement($programId)) {
            // set the owning side to null (unless already changed)
            if ($programId->getProgramActor() === $this) {
                $programId->setProgramActor(null);
            }
        }

        return $this;
    }
}
