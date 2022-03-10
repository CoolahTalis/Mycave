<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VinRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=VinRepository::class)
 * @Vich\Uploadable
 */
class Vin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grapes;


    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;


    /**
     * @Vich\UploadableField(mapping="vin_image", fileNameProperty="picture")
     * 
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Domaine::class, inversedBy="dom")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dom;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGrapes(): ?string
    {
        return $this->grapes;
    }

    public function setGrapes(string $grapes): self
    {
        $this->grapes = $grapes;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
    
    public function getPhoto(): ?File
    {
        return $this->photo;
    }
    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $photo
     */
    public function setPhoto(?File $photo = null): self
    {
        $this->photo = $photo;
        
        if ($this->photo instanceof UploadedFile) {
            $this->updatedAt = new \DateTime("now");
        }
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDom(): ?Domaine
    {
        return $this->dom;
    }

    public function setDom(?Domaine $dom): self
    {
        $this->dom = $dom;

        return $this;
    }

}