<?php

namespace App\Entity;

use App\Repository\DomaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DomaineRepository::class)
 */
class Domaine
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
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Vin::class, mappedBy="dom", orphanRemoval=true)
     */
    private $dom;

    public function __construct()
    {
        $this->name = new ArrayCollection();
        $this->dom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
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
     * @return Collection|Vin[]
     */
    public function getDom(): Collection
    {
        return $this->dom;
    }

    public function addDom(Vin $dom): self
    {
        if (!$this->dom->contains($dom)) {
            $this->dom[] = $dom;
            $dom->setDom($this);
        }

        return $this;
    }

    public function removeDom(Vin $dom): self
    {
        if ($this->dom->removeElement($dom)) {
            // set the owning side to null (unless already changed)
            if ($dom->getDom() === $this) {
                $dom->setDom(null);
            }
        }

        return $this;
    }
}
