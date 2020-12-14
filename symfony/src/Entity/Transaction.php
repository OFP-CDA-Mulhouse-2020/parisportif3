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
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private DateTimeInterface $transactionDate;

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

    public function setTransactionDate(DateTimeInterface $transactionDate): self
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }
}
