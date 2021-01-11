<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity({"transaction", "betChoice", "betData"})
 */
final class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Transaction::class, inversedBy="betList")
     * @ORM\JoinColumn(nullable=false)
     */
    private Transaction $transaction;

    /**
     * @ORM\OneToOne(targetEntity=BetData::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private BetData $betData;

    /**
     * @ORM\OneToOne(targetEntity=BetChoice::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private BetChoice $betChoice;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getBetData(): ?BetData
    {
        return $this->betData;
    }

    public function setBetData(BetData $betData): self
    {
        $this->betData = $betData;

        return $this;
    }

    public function getBetChoice(): ?BetChoice
    {
        return $this->betChoice;
    }

    public function setBetChoice(BetChoice $betChoice): self
    {
        $this->betChoice = $betChoice;

        return $this;
    }
}
