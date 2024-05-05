<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email(
        message: "Email {{ value }} n'est pas valide"
    )]
    #[Assert\NotBlank(
        message: 'Saisir une adresse mail valide'
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Saisir un mot de passe'
    )]
    // #[Assert\Length(
    //     min: 10,
    //     minMessage: 'Mot de passe trop court'
    // )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Saisir un prenom'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: 'Prenom trop court',
        max: 255,
        maxMessage: 'Prenom trop long'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Saisir un nom'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: 'Nom trop court',
        max: 255,
        maxMessage: 'Nom trop long'
    )]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateofbirth = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Saisir une ville'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: 'Nom de ville trop court',
        max: 255,
        maxMessage: 'Nom de ville trop long'
    )]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(
        message: 'Saisir une url'
    )]
    #[Assert\Url(
        message: 'Saisir une url valide'
    )]
    private ?string $picture = null;

    /**
     * @var Collection<int, Vma>
     */
    #[ORM\OneToMany(targetEntity: Vma::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $vmas;

    public function __construct()
    {
        $this->vmas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getDateofbirth(): ?\DateTimeInterface
    {
        return $this->dateofbirth;
    }

    public function setDateofbirth(\DateTimeInterface $dateofbirth): static
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Vma>
     */
    public function getVmas(): Collection
    {
        return $this->vmas;
    }

    public function addVma(Vma $vma): static
    {
        if (!$this->vmas->contains($vma)) {
            $this->vmas->add($vma);
            $vma->setUser($this);
        }

        return $this;
    }

    public function removeVma(Vma $vma): static
    {
        if ($this->vmas->removeElement($vma)) {
            // set the owning side to null (unless already changed)
            if ($vma->getUser() === $this) {
                $vma->setUser(null);
            }
        }

        return $this;
    }
}
