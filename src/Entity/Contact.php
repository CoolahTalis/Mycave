<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
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
    private $emailto;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usermail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailto(): ?string
    {
        return $this->emailto;
    }

    public function setEmailto(string $emailto): self
    {
        $this->emailto = $emailto;

        return $this;
    }


    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function __toString()
    {
        return $this->user;
        return $this->usermail;

    }

    public function getUsermail(): ?User
    {
        return $this->usermail;
    }

    public function setUsermail(?User $usermail): self
    {
        $this->usermail = $usermail;

        return $this;
    }


    
}
