<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $role;

    /**
     * @var Collection<\App\Entity\Rating>
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     */
    private Collection $ratings;

    public function __construct(string $name, string $email, string $password, bool $isAdmin)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $isAdmin ? 'ROLE_ADMIN' : 'ROLE_USER';
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getPassword(): string
    {
       return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection<\App\Entity\Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }
}
