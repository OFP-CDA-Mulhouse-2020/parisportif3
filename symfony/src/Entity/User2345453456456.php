<?php

namespace App\Entity;

use App\Repository\User2345453456456Repository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User2345453456456 implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private int $username;
    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];
    /**
     * @ORM\Column(type="string")
     */
    private string $password;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isActivated;
    /**
     * @ORM\Column(type="datetimetz")
     */
    private DateTimeZone $timezone;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $creationDate;
    /**
     * @ORM\Column(type="date")
     */
    private DateTime $birthDate;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $isActivatedAt;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $suspended;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $suspendedAt;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $deleted;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $deletedAt;

    public function __construct()
    {
        $this->creationDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function markAsVerified(): self
    {
        $this->isVerified = true;

        return $this;
    }

    public function isActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function activate(): self
    {
        $this->isActivated = true;

        return $this;
    }

    public function getTimezone(): ?DateTimeZone
    {
        return $this->timezone;
    }

    public function setTimezone(DateTimeZone $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->creationDate;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getActivatedAt(): ?DateTime
    {
        return $this->isActivatedAt;
    }

    public function setActivatedAt(DateTime $isActivatedAt): self
    {
        $this->isActivatedAt = $isActivatedAt;

        return $this;
    }

    public function getSuspended(): ?bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): self
    {
        $this->suspended = $suspended;

        return $this;
    }

    public function getSuspendedAt(): ?DateTime
    {
        return $this->suspendedAt;
    }

    public function setSuspendedAt(?DateTime $suspendedAt): self
    {
        $this->suspendedAt = $suspendedAt;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
