<?php

namespace App\Entity;

use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private string $username;
    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];
    /**
     * @var string|null The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;
    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $birthDate;
    /**
     * @ORM\Column(type="datetimetz")
     */
    private DateTimeZone $timeZone;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $suspendedAt;

    /**
     * @ORM\Column(type="bool")
     */
    private bool $suspended = false;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    final public function getId(): ?int
    {
        return $this->id;
    }

    final public function getUsername(): string
    {
        return $this->username;
    }

    final public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    final public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    final public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    final public function getPassword(): string
    {
        return $this->password;
    }

    final public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    final public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    final public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    final public function createdAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    final public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    final public function isUserOldEnough(): bool
    {
        $now = new DateTime();
        $now
            ->setTimezone(new DateTimeZone("Europe/Paris"))
            ->setTime(0, 0);

        return $now->diff($this->getBirthDate()) >= "18";
    }

    private function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    final public function getTimeZone(): ?DateTimeZone
    {
        return $this->timeZone;
    }

    final public function getLastName(): ?string
    {
        return $this->lastName;
    }

    final public function setLastName(string $lastName): self
    {
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $lastName)) {
            throw new InvalidLastNameException("Your lastname is invalid.");
        }
        $this->lastName = $lastName;
        return $this;
    }

    final public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    final public function setFirstName(string $firstName): self
    {
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $firstName)) {
            throw new InvalidFirstNameException("Your firstname is invalid.");
        }
        $this->firstName = $firstName;
        return $this;
    }

    final public function suspended(): void
    {
        $this->suspended = true;
        $this->suspendedAt = new DateTime();
    }

    final public function isSuspended(): bool
    {
        return $this->suspended;
    }

    final public function suspendedAt(): DateTimeInterface
    {
        return $this->suspendedAt;
    }
}
