<?php

/**
 * @author  Etienne Schmitt <etienne@schmitt-etienne.fr>
 * @license GPL 2.0 or any later
 */

namespace App\Tests\Entity;

use App\Tests\GeneralTestMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class CartItemTest extends TestCase
{
    private TraceableValidator $validator;
    private CartItem $cart;

    public function setUp(): void
    {
        $this->cart = new CartItem();
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
    }

    public function testCartItemClassExist(): void
    {
        $this->assertInstanceOf(CartItem::class, $this->cart);
    }
}
