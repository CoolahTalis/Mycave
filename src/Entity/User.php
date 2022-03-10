<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * UniqueEntity(fields={"username"}, message="Ce username est déja pris !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    // CHECK ASSERT POUR MAIL !!!!
    private $email;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min=5, max=12, minMessage=" Mot de passe trop court, 5 caractères minimum", maxMessage=" Mot de passe trop long, 12 caractères maximum")
     * 
     */
    private $password;

    /**
     * @var string The hashed password
     * 
     * @Assert\Length(min=5, max=12, minMessage=" Nom d'user trop court, 5 caractères minimum", maxMessage=" Nom d'user trop long, 12 caractères maximum")
     */
    private $passwordVerification;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=12, minMessage=" Nom d'user trop court, 5 caractères minimum", maxMessage=" Nom d'user trop long, 12 caractères maximum")
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="usermail", orphanRemoval=true)
     */
    private $contact;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    
    
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @see UserInterface
     */
    public function getPasswordVerification(): string
    {
        return (string) $this->passwordVerification;
    }
    
    public function setPasswordVerification(string $passwordVerification): self
    {
        $this->passwordVerification = $passwordVerification;
        
        return $this;
    }
    
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    
    public function getRoles()
    {
        return ['ROLE'];
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setUsermail($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUsermail() === $this) {
                $contact->setUsermail(null);
            }
        }

        return $this;
    }
}
