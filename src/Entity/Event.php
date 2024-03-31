<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startdate = null;

    #[ORM\Column]
    private ?LocationEnum $location = null;

    #[ORM\Column(nullable: true)]
    private ?int $maximumcapacity = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $referent = null;

    #[ORM\OneToMany(targetEntity: Encounter::class, mappedBy: 'event')]
    private Collection $encounters;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'events')]
    private Collection $attendies;

    public function __construct()
    {
        $this->encounters = new ArrayCollection();
        $this->attendies = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): static
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getLocation(): ?LocationEnum
    {
        return $this->location;
    }

    public function setLocation(LocationEnum $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getMaximumcapacity(): ?int
    {
        return $this->maximumcapacity;
    }

    public function setMaximumcapacity(?int $maximumcapacity): static
    {
        $this->maximumcapacity = $maximumcapacity;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getReferent(): ?User
    {
        return $this->referent;
    }

    public function setReferent(?User $referent): static
    {
        $this->referent = $referent;

        return $this;
    }

    /**
     * @return Collection<int, Encounter>
     */
    public function getEncounters(): Collection
    {
        return $this->encounters;
    }

    public function addEncounter(Encounter $encounter): static
    {
        if (!$this->encounters->contains($encounter)) {
            $this->encounters->add($encounter);
            $encounter->setEvent($this);
        }

        return $this;
    }

    public function removeEncounter(Encounter $encounter): static
    {
        if ($this->encounters->removeElement($encounter)) {
            // set the owning side to null (unless already changed)
            if ($encounter->getEvent() === $this) {
                $encounter->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAttendies(): Collection
    {
        return $this->attendies;
    }

    public function addAttendy(User $attendy): static
    {
        if (!$this->attendies->contains($attendy)) {
            $this->attendies->add($attendy);
        }

        return $this;
    }

    public function removeAttendy(User $attendy): static
    {
        $this->attendies->removeElement($attendy);

        return $this;
    }

    public function getTags(): Collection
    {
        $tags = new ArrayCollection();

        foreach ($this->getEncounters() as $encounter) {
            foreach ($encounter->getTags() as $tag) {
                if (!$tags->contains($tag)) {
                    $tags->add($tag);
                }
            }
        }

        return $tags;
    }
    public function getLocation(): ?LocationEnum
    {
        return $this->location;
    }

    public function setLocation(?LocationEnum $location): static
    {
        $this->location = $location;

        return $this;
    }

}
