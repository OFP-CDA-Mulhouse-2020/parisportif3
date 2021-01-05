<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
final class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=CartItem::class)
     */
    private ?CartItem $cartItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCartItem(): ?CartItem
    {
        return $this->cartItem;
    }

    public function setCartItem(?CartItem $cartItem): self
    {
        $this->cartItem = $cartItem;

        return $this;
    }
}
