<?php

namespace App\Entity;

use App\Exception\InvalidEmailException;
use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
final class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @var array<string>
     * @ORM\Column(type="json")
     */
    private array $roles = [];
    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $username;
    /** @ORM\Column(type="string") */
    private string $password;
    /** @ORM\Column(type="string", length=255) */
    private string $email;
    /** @ORM\Column(type="date") */
    private DateTimeInterface $birthDate;
    /** @ORM\Column(type="string", length=120) */
    private string $timeZone;
    /** @ORM\Column(type="datetime") */
    private DateTimeInterface $createdAt;
    /** @ORM\Column(type="boolean") */
    private bool $active = false;
    /** @ORM\Column(type="date") */
    private DateTimeInterface $activatedAt;
    /** @ORM\Column(type="boolean") */
    private bool $deleted = false;
    /** @ORM\Column(type="date") */
    private DateTimeInterface $deletedAt;
    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $lastName;
    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $firstName;
    /** @ORM\Column(type="date") */
    private DateTimeInterface $suspendedAt;
    /** @ORM\Column(type="bool") */
    private bool $suspended = false;

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
        $validator = Validation::createValidator();
        $emailConstraint = new Email(
            [
                "mode" => Email::VALIDATION_MODE_STRICT
            ]
        );

        $errors = $validator->validate($email, $emailConstraint);

        if (count($errors) !== 0) {
            /** @var ConstraintViolation[] $errors */
            $errorMessage = $errors[0]->getMessage();
            throw new InvalidEmailException($errorMessage);
        }

        $this->email = $email;

        return $this;
    }

    public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    //TODO a fixé rapidement
    public function isUserOldEnough(): bool
    {
        $now = new DateTime();
        $now
            ->setTimezone(new DateTimeZone("Europe/Paris"))
            ->setTime(0, 0);

        return $now->diff($this->getBirthDate()) >= "18";
    }

    private function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): self
    {
        if (!$this->isValidTimeZone($timeZone)) {
            throw new InvalidTimeZone("Invalid Timezone");
        }
        $this->timeZone = $timeZone;

        return $this;
    }

    private function isValidTimeZone(string $timeZone): bool
    {
        return in_array($timeZone, DateTimeZone::listIdentifiers(), true);
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
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $firstName))
        {
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

    public function suspendedAt(): DateTimeInterface
    {
        return $this->suspendedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        try {
            if ($this->isPasswordStrongEnough($password)) {
                $this->password = $password;
            }
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(): void
    {
        $this->active = true;
        $this->activatedAt = new DateTime();
    }

    public function activatedAt(): DateTimeInterface
    {
        return $this->activatedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function deletedAt(): DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function delete(): void
    {
        $this->deleted = true;
        $this->deletedAt = new DateTime();
    }

    public static function isPasswordStrongEnough(string $password): bool
    {
        if (!preg_match('/\d+/', $password)) {
            throw new InvalidArgumentException("\nIl manque au moins un chiffre.");
        } elseif (!preg_match('/[a-zA-Z]+/', $password)) {
            throw new InvalidArgumentException("\nIl manque au moins une lettre.");
        } elseif (strlen($password) < 8 || strlen($password) > 32) {
            throw new InvalidArgumentException("\nLa longueur du mot de passe est invalide");
        } else {
            return true;
        }
    }
}
