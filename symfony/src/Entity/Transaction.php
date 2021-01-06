<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @UniqueEntity(fields={"id"})
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
     * @Assert\GreaterThan(0)
     */
    private int $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactionHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=CartItem::class, mappedBy="transaction")
     * @var Collection<int, CartItem>
     */
    private Collection $cartItemList;

    public function __construct()
    {
        $this->transactionDate = new DateTime();
        $this->cartItemList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?DateTimeInterface
    {
        return $this->transactionDate;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /** @return Collection<int, CartItem> */
    public function getCartItemList(): Collection
    {
        return $this->cartItemList;
    }

    public function addCartItemList(CartItem $cartItemList): self
    {
        if (!$this->cartItemList->contains($cartItemList)) {
            $this->cartItemList[] = $cartItemList;
            $cartItemList->setTransaction($this);
        }

        return $this;
    }

    public function removeCartItemList(CartItem $cartItemList): self
    {
        if ($this->cartItemList->removeElement($cartItemList)) {
            // set the owning side to null (unless already changed)
            if ($cartItemList->getTransaction() === $this) {
                $cartItemList->setTransaction(null);
            }
        }

        return $this;
    }
}
