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
 * @UniqueEntity("id")
 * @UniqueEntity({"transactionDate", "betList", "user"})
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
     */
    private DateTimeInterface $transactionDate;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     */
    private int $totalPrice;

    /**
     * @var Collection<int, Bet>
     *
     * @ORM\ManyToMany(targetEntity=Bet::class)
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

    public function getTransactionDate(): DateTimeInterface
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

    /** @return Collection<int, Bet> */
    public function getBetList(): Collection
    {
        return $this->betList;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->betList->contains($bet)) {
            $this->betList[] = $bet;
        }

        return $this;
    }
}
