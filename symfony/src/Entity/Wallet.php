<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @UniqueEntity("id")
 */
final class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private int $balance = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function addToBalance(int $balance): self
    {
        $this->balance += $balance;

        return $this;
    }

    public function removeFromBalance(int $balance): self
    {
        $this->balance -= $balance;

        return $this;
    }
}
