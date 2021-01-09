<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @UniqueEntity(fields={"id"})
 */
final class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     */
    private DateTimeInterface $transactionDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private int $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactionHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="transaction")
     * @var Collection<int, Bet>
     */
    private Collection $betList;


    public function __construct()
    {
        $this->transactionDate = new DateTime();
        $this->betList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?DateTimeInterface
    {
        return $this->transactionDate;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /** @return Collection<int, Bet> */
    public function getBetList(): Collection
    {
        return $this->betList;
    }

    public function addBetToList(Bet $bet): self
    {
        if (!$this->betList->contains($bet)) {
            $this->betList[] = $bet;
            $bet->setTransaction($this);
        }

        return $this;
    }
}
