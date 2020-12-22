<?php

namespace App\Tests\Entity;

use App\Entity\Cart;
use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase
{
    public function testCreateCart(): void
    {
        $cart = new Cart();

        $this->assertInstanceOf(Cart::class, $cart);
    }
    //TODO faire la relation de génération avec la class Transaction

    //TODO faire la relation opérer par la class User
}
