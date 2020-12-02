<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Exception\InvalidEmailException;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    final public function testConstructor(): void
    {
        $user = new User();

        self::assertInstanceOf(User::class, $user);
        self::assertInstanceOf(DateTimeInterface::class, $user->createdAt());
        self::assertLessThanOrEqual(new DateTime(), $user->createdAt());
    }

    final public function testValidEmail(): void
    {
        $user = new User();
        $email = "mail-address@mail.com";

        $user->setEmail($email);

        self::assertSame($email, $user->getEmail());
    }

    final public function testInvalidValidEmail(): void
    {
        $user = new User();
        $email = "mîiladøïress@ma@il.com";

        $this->expectException(InvalidEmailException::class);
        $user->setEmail($email);
    }

    final public function testUserBirthDate(): void
    {
        $user = new User();
        $user->setBirthDate(new DateTime("2000-06-12"));

        self::assertTrue($user->isUserOldEnough());
    }
}
