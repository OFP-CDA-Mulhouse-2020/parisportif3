<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("username")
 */
final class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var array<string>
     *
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /** Personal data */

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotBlank
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(mode="strict")
     * @Assert\NotBlank
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=180)
     *
     * @Assert\NotBlank
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=180)
     *
     * @Assert\NotBlank
     */
    private string $firstName;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $birthDate;

    /**
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\Timezone
     *
     * @TODO Rendre dynamique selon l'entrée de l'utilisateur
     */
    private string $timeZone = "Europe/Paris";

    /**
     * @ORM\OneToOne(targetEntity=Wallet::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid
     */
    private Wallet $wallet;

    /**
     * @var Collection<int, Transaction>
     *
     * @ORM\ManyToMany(targetEntity=Transaction::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(unique=true)
     *     }
     * )
     *
     * @note Not a ManyToMany!
     *       JoinColumn is set to unique, for more details look at
     *       <b>One-To-Many, Unidirectional with Join Table<b> on
     *       Doctrine documentation (link below as of 2021-01-20)
     *
     * @link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table
     *
     * @TODO Valider avec un callback
     */
    private Collection $transactionHistory;

    /**
     * @var Collection<int, Receipt>
     *
     * @ORM\ManyToMany(targetEntity=Receipt::class)
     * @ORM\JoinTable(
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(unique=true)
     *     }
     * )
     *
     * @note Not a ManyToMany!
     *       JoinColumn is set to unique, for more details look at
     *       <b>One-To-Many, Unidirectional with Join Table<b> on
     *       Doctrine documentation (link below as of 2021-01-20)
     *
     * @link https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#one-to-many-unidirectional-with-join-table
     *
     * @TODO Valider avec un callback
     */
    private Collection $receiptsHistory;

    /** Dates */

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $verifiedAt;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $deletedAt;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $activatedAt;

    /** @ORM\Column(type="date", nullable=true) */
    private ?DateTimeInterface $suspendedAt;

    /** Status */

    /** @ORM\Column(type="boolean") */
    private bool $active = false;

    /** @ORM\Column(type="boolean") */
    private bool $verified = false;

    /** @ORM\Column(type="boolean") */
    private bool $suspended = false;

    /** @ORM\Column(type="boolean") */
    private bool $deleted = false;


    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->transactionHistory = new ArrayCollection();
        $this->receiptsHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /** Personal Data */

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
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

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
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

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /** @return Collection<int, Transaction> */
    public function getTransactionHistory(): Collection
    {
        return $this->transactionHistory;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactionHistory->contains($transaction)) {
            $this->transactionHistory[] = $transaction;
        }

        return $this;
    }

    /** @return Collection<int, Receipt> */
    public function listReceiptsHistory(): Collection
    {
        return $this->receiptsHistory;
    }

    public function addReceiptToHistory(Receipt $receiptToAdd): self
    {
        if (!$this->receiptsHistory->contains($receiptToAdd)) {
            $this->receiptsHistory[] = $receiptToAdd;
        }

        return $this;
    }

    public function removeReceiptFromHistory(Receipt $receiptToRemove): self
    {
        $this->receiptsHistory->removeElement($receiptToRemove);

        return $this;
    }

    /** Dates */

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function verifiedAt(): ?DateTimeInterface
    {
        return $this->verifiedAt;
    }

    public function deletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function activatedAt(): ?DateTimeInterface
    {
        return $this->activatedAt;
    }

    public function suspendedAt(): ?DateTimeInterface
    {
        return $this->suspendedAt;
    }

    /** Status */

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

    public function verify(): self
    {
        $this->verified = true;
        $this->verifiedAt = new DateTime();
        return $this;
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    public function suspend(): void
    {
        $this->suspended = true;
        $this->suspendedAt = new DateTime();
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function delete(): void
    {
        $this->deleted = true;
        $this->deletedAt = new DateTime();
    }

    /**
     * @TODO Implémenter
     * @phpstan-ignore-next-line
     */
    public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /** Custom validation */

    /** @Assert\Callback */
    public function validateUsername(ExecutionContextInterface $context): void
    {
        //TODO checker les regex
        if (!preg_match("/^[A-Za-z0-9]+$/u", $this->username)) {
            $context->buildViolation("The username is not a valid username")
                ->atPath("choice")
                ->addViolation();
        }
    }

    /** @Assert\Callback */
    public function validateNames(ExecutionContextInterface $context): void
    {
        //TODO checker les regex

        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $this->firstName)) {
            $context->buildViolation("The firstName is not a valid firstName")
                ->atPath("firstName")
                ->addViolation();
        }
        if (!preg_match("/^[A-Za-zÄ-ÿ_.-]+$/u", $this->lastName)) {
            $context->buildViolation("The lastName is not a valid lastName")
                ->atPath("lastName")
                ->addViolation();
        }
    }

    /**
     * @Assert\Callback
     * @throws Exception
     */
    public function validateUserOldEnough(ExecutionContextInterface $context): void
    {
        //TODO rentre l'age limite dynamique

        $now = new DateTime();
        $now->setTime(0, 0);

        $ageDiff = $now->diff($this->birthDate);

        $userAge = (int)$ageDiff->format('%Y');

        if ($userAge < 18) {
            $context->buildViolation("This user is too young")
                ->atPath("birthDate")
                ->addViolation();
        }
    }
}
