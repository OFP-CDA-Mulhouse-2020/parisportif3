<?php

namespace App\Entity;

use App\Repository\BetRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
final class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(1)
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private int $amount;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(2)
     */
    private int $status;

    public const STATUS_UNPAID = 0;
    public const STATUS_PENDING = 1;
    public const STATUS_PAID = 2;

    /** @var array|string[] */
    public static array $statusList = [
        self::STATUS_UNPAID => "STATUS_UNPAID",
        self::STATUS_PENDING => "STATUS_PENDING",
        self::STATUS_PAID => "STATUS_PAID"
    ];

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotNull
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(100)
     */
    private int $cote;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCote(): ?int
    {
        return $this->cote;
    }

    public function setCote(int $cote): self
    {
        $this->cote = $cote;

        return $this;
    }
}
