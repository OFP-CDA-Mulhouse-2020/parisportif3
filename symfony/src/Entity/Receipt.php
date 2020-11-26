<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReceiptRepository::class)
 */
class Receipt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity=Wallet::class, mappedBy="receipt")
     */
    private $wallet;

    public function __construct()
    {
        $this->wallet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|Wallet[]
     */
    public function getWallet(): Collection
    {
        return $this->wallet;
    }

    public function addWallet(Wallet $wallet): self
    {
        if (!$this->wallet->contains($wallet)) {
            $this->wallet[] = $wallet;
            $wallet->setReceipt($this);
        }

        return $this;
    }

    public function removeWallet(Wallet $wallet): self
    {
        if ($this->wallet->removeElement($wallet)) {
            // set the owning side to null (unless already changed)
            if ($wallet->getReceipt() === $this) {
                $wallet->setReceipt(null);
            }
        }

        return $this;
    }

}
