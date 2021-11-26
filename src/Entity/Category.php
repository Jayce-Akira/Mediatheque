<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=livre::class, mappedBy="category")
     */
    private $relationlivre;

    public function __construct()
    {
        $this->relationlivre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|livre[]
     */
    public function getRelationlivre(): Collection
    {
        return $this->relationlivre;
    }

    public function addRelationlivre(livre $relationlivre): self
    {
        if (!$this->relationlivre->contains($relationlivre)) {
            $this->relationlivre[] = $relationlivre;
            $relationlivre->setCategory($this);
        }

        return $this;
    }

    public function removeRelationlivre(livre $relationlivre): self
    {
        if ($this->relationlivre->removeElement($relationlivre)) {
            // set the owning side to null (unless already changed)
            if ($relationlivre->getCategory() === $this) {
                $relationlivre->setCategory(null);
            }
        }

        return $this;
    }
}

