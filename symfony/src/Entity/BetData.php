<?php

namespace App\Entity;

use App\Repository\BetDataRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetDataRepository::class)
 * @UniqueEntity("id")
 */
final class BetData
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
     * @Assert\NotNull
     */
    private int $amount;

    /**
     * @ORM\Column(type="boot")
     *
     * @Assert\NotNull
     */
    private bool $paidStatus;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotNull
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull
     * @Assert\GreaterThan(100)
     */
    private int $cote;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaidStatus(): bool
    {
        return $this->paidStatus;
    }

    public function setPaidStatus(bool $paidStatus): self
    {
        $this->paidStatus = $paidStatus;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCote(): int
    {
        return $this->cote;
    }

    public function setCote(int $cote): self
    {
        $this->cote = $cote;

        return $this;
    }
}
