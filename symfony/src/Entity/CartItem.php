<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 * @UniqueEntity("id")
 */
final class CartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Transaction::class, inversedBy="cartItemList")
     * @ORM\JoinColumn(nullable=false)
     */
    private Transaction $transaction;

    /**
     * @ORM\OneToOne(targetEntity=Bet::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Bet $bet;

    /**
     * @ORM\OneToOne(targetEntity=BetChoice::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private BetChoice $betChoice;

    public function getId(): int
    {
        return $this->id;
    }

    //TODO Ajouter la relation avec Bet

    //TODO Ajouter la relation avec BetChoices

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getBet(): ?Bet
    {
        return $this->bet;
    }

    public function setBet(Bet $bet): self
    {
        $this->bet = $bet;

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
