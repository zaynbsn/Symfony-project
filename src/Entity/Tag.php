<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'supertag')]
    private ?self $subtags = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'subtags')]
    private Collection $supertag;

    #[ORM\Column(length: 255)]
    private ?string $imageurl = null;

    #[ORM\Column]
    private ?TagType $type = null;

    public function __construct()
    {
        $this->supertag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSubtags(): ?self
    {
        return $this->subtags;
    }

    public function setSubtags(?self $subtags): static
    {
        $this->subtags = $subtags;

        return $this;
    }

    public function getType(): ?TagType
    {
        return $this->type;
    }

    public function setType(?TagType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSupertag(): Collection
    {
        return $this->supertag;
    }

    public function addSupertag(self $supertag): static
    {
        if (!$this->supertag->contains($supertag)) {
            $this->supertag->add($supertag);
            $supertag->setSubtags($this);
        }

        return $this;
    }

    public function removeSupertag(self $supertag): static
    {
        if ($this->supertag->removeElement($supertag)) {
            // set the owning side to null (unless already changed)
            if ($supertag->getSubtags() === $this) {
                $supertag->setSubtags(null);
            }
        }

        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(string $imageurl): static
    {
        $this->imageurl = $imageurl;

        return $this;
    }

}
