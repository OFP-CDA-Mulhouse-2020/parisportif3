<?php

namespace App\Entity;

use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"id", "username"},
 *     errorPath="username"
 * )
 */
final class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Assert\Unique
     * @Assert\NotNull
     */
    private int $id;

    /**
     * @var array<string>
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\Unique
     * @Assert\NotNull
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotNull
     * @Assert\NotCompromisedPassword
     * @SecurityAssert\UserPassword
     *
     * @TODO Ajouter un validator pour supprimé les test dans ::setPassword() et ::isPasswordStrongEnough()
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(mode="strict")
     */
    private string $email;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotNull
     *
     * @TODO Ajouter un validator pour vérifier si l'utilisateur à l'age avant de l'ajouter
     */
    private DateTimeInterface $birthDate;

    /**
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\NotNull
     * @Assert\Timezone
     */
    private string $timeZone;

    /**
     * @ORM\Column(type="string", length=180)
     *
     * @Assert\NotNull
     *
     * @TODO Ajouter un validator custom pour tester le nom
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=180)
     *
     * @Assert\NotNull
     *
     * @TODO Ajouter un validator custom pour tester le nom
     */
    private string $firstName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotNull
     */
    private DateTimeInterface $createdAt;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $suspendedAt;

    /** @ORM\Column(type="boolean") */
    private bool $suspended = false;

    /** @ORM\Column(type="boolean") */
    private bool $active = false;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $activatedAt;

    /** @ORM\Column(type="boolean") */
    private bool $verified = false;
    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $verifiedAt;
    /** @ORM\Column(type="boolean") */
    private bool $deleted = false;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $deletedAt;


    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
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

    /** @param array<string> $roles */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    //TODO Implémenter @phpstan-ignore-next-line
    public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    //TODO Implémenter
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isUserOldEnough(): bool
    {
        $now = (new DateTime())
            ->setTimezone(new DateTimeZone('Europe/Paris'))
            ->setTime(0, 0);

        return ((int)($now->diff($this->getBirthDate())->format('%Y'))) >= 18;
    }

    private function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $lastName)) {
            throw new InvalidLastNameException("Your lastname is invalid.");
        }
        $this->lastName = $lastName;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $firstName)) {
            throw new InvalidFirstNameException("Your firstname is invalid.");
        }
        $this->firstName = $firstName;
        return $this;
    }

    public function suspend(): void
    {
        $this->suspended = true;
        $this->suspendedAt = new DateTime();
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    public function suspendedAt(): ?DateTimeInterface
    {
        return $this->suspendedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): bool
    {
        try {
            if ($this->isPasswordStrongEnough($password)) {
                $this->password = $password;
                return true;
            }
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function isPasswordStrongEnough(string $password): bool
    {
        if (!preg_match('/\d+/', $password)) {
            throw new InvalidArgumentException("\nIl manque au moins un chiffre.");
        }

        if (!preg_match('/[a-zA-Z]+/', $password)) {
            throw new InvalidArgumentException("\nIl manque au moins une lettre.");
        }

        $passwordLength = strlen($password);
        if ($passwordLength < 8) {
            throw new InvalidArgumentException("\nLa longueur du mot de passe est trop courte");
        }

        if ($passwordLength > 32) {
            throw new InvalidArgumentException("\nLa longueur du mot de passe est trop longue");
        }

        return true;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function activate(): self
    {
        $this->active = true;
        $this->activatedAt = new DateTime();
        return $this;
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function setVerified(): self
    {
        $this->verified = true;
        return $this;
    }

    public function activatedAt(): ?DateTimeInterface
    {
        return $this->activatedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function deletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function delete(): void
    {
        $this->deleted = true;
        $this->deletedAt = new DateTime();
    }
}
