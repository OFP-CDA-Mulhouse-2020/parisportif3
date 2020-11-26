<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CartItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cartItem;

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
