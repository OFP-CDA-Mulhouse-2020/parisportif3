<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReceiptRepository::class)
 * @UniqueEntity("id")
 * @TODO Ajouter unicité avec User ? (voir TODO en bas)
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
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    private int $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $date;

    //TODO Ajouter une relation avec User? Car seulement cet utilisateur est sensé y avoir accès


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

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
