<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $betAmount;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wallet;

    /**
     * @ORM\OneToMany(targetEntity=BetTemplateChoice::class, mappedBy="transaction", orphanRemoval=true)
     */
    private $betTemplateChoice;

    public function __construct()
    {
        $this->betTemplateChoice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBetAmount(): ?float
    {
        return $this->betAmount;
    }

    public function setBetAmount(float $betAmount): self
    {
        $this->betAmount = $betAmount;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return Collection|BetTemplateChoice[]
     */
    public function getBetTemplateChoice(): Collection
    {
        return $this->betTemplateChoice;
    }

    public function addBetTemplateChoice(BetTemplateChoice $betTemplateChoice): self
    {
        if (!$this->betTemplateChoice->contains($betTemplateChoice)) {
            $this->betTemplateChoice[] = $betTemplateChoice;
            $betTemplateChoice->setTransaction($this);
        }

        return $this;
    }

    public function removeBetTemplateChoice(BetTemplateChoice $betTemplateChoice): self
    {
        // set the owning side to null (unless already changed)
        if ($this->betTemplateChoice->removeElement($betTemplateChoice) && $betTemplateChoice->getTransaction() === $this) {
            $betTemplateChoice->setTransaction(null);
        }

        return $this;
    }

}
