<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReceiptRepository::class)
 * @TODO Ajouter entité unique
 */
final class Receipt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     */
    private int $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @TODO besoin d'un wallet OU de la valeur d'un wallet à un instant T?
     */
    private Wallet $wallet;

    //TODO Ajouter une relation avec User, car seulement cette utilisateurs est sensé y avoir accès

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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
}
