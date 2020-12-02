<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
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
     * @var string The hashed password
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
     * @ORM\Column(type="boolean")
     */
    private bool $active = false;
    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $activatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $deleted = false;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $deletedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    final public function getId(): int
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

    final public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    final public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    final public function createdAt(): DateTimeInterface
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

    private function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    final public function getTimeZone(): DateTimeZone
    {
        return $this->timeZone;
    }

    final public function getPassword(): string
    {
        return $this->password;
    }

    final public function setPassword(string $password): self
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

    final public function isActive(): bool
    {
        return $this->active;
    }

    final public function activatedAt(): DateTimeInterface
    {
        return $this->activatedAt;
    }

    final public function setActive(): void
    {
        $this->active = true;
        $this->activatedAt = new DateTime();
    }

    final public function isDeleted(): bool
    {
        return $this->deleted;
    }

    final public function deletedAt(): DateTimeInterface
    {
        return $this->deletedAt;
    }

    final public function delete(): void
    {
        $this->deleted = true;
        $this->deletedAt = new DateTime();
    }

    /**
     * @param $password
     * @return bool
     */
    final public static function isPasswordStrongEnough(string $password): bool
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
