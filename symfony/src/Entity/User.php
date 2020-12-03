<?php

namespace App\Entity;

use App\Exception\InvalidEmailException;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

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
    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $username;
    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];
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

    final public function getEmail(): ?string
    {
        return $this->email;
    }

    final public function setEmail(string $email): self
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

    final public function setTimeZone(string $timeZone): self
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

    final public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
