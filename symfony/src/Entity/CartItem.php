<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 */
class CartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Bet::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bet;

    /**
     * @ORM\OneToOne(targetEntity=BetChoices::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $betChoices;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBetChoices(): ?BetChoices
    {
        return $this->betChoices;
    }

    public function setBetChoices(BetChoices $betChoices): self
    {
        $this->betChoices = $betChoices;

        return $this;
    }
}
