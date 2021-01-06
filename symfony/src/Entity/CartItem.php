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
}
