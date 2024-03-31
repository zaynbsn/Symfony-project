<?php

namespace App\Entity;

use App\Repository\EncounterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[ORM\Entity(repositoryClass: EncounterRepository::class)]
class Encounter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'encounters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $firstteam = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $secondteam = null;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;


    #[ORM\Column(nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'encounters')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Event $event = null;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->description = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstteam(): ?Tag
    {
        return $this->firstteam;
    }

    public function setFirstteam(?Tag $firstteam): static
    {
        $this->firstteam = $firstteam;

        return $this;
    }

    public function getSecondteam(): ?Tag
    {
        return $this->secondteam;
    }

    public function setSecondteam(?Tag $secondteam): static
    {
        $this->secondteam = $secondteam;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }


    private function computeDescription(): void
    {
        if ($this->firstteam && $this->secondteam) {
            $this->description = $this->firstteam->getName() . ' vs ' . $this->secondteam->getName();
        }
    }
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
    public function getDescription(): ?string
    {
        if ($this->firstteam && $this->secondteam) {
            return $this->firstteam->getName() . ' vs ' . $this->secondteam->getName();
        }
        return null;
    }
    #[ORM\PostPersist]
    public function postPersistHandler(LifecycleEventArgs $args): void
    {
        $this->computeDescription();
    }


}
