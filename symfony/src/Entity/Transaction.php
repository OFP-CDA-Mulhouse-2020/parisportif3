<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @UniqueEntity(
 *     fields={"id"},
 *     errorPath="ID"
 * )
 */
final class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     */
    private DateTimeInterface $transactionDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan (99)
     */
    private int $amount;

    public function __construct()
    {
        $this->transactionDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?DateTimeInterface
    {
        return $this->transactionDate;
    }

    //TODO:: Ajouter la relation avec Wallet

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    //TODO:: Ajouter la relation avec BetTemplateChoice
}
