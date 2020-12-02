<?php

namespace App\Tests\Entity;

use App\Entity\User;
use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
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

    final public function testUserBirthDate(): void
    {
        $user = new User();
        $user->setBirthDate(new DateTime("2000-06-12"));

        self::assertTrue($user->isUserOldEnough());
    }

    final public function testPassWordIsValid(): void
    {
        try {
            self::assertTrue(User::isPasswordStrongEnough('1AAZDSQDq'));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


     /** @dataProvider passProvider */
    final public function testPassWordIsInvalid(string $a): void
    {
        self::expectException(InvalidArgumentException::class);
        User::isPasswordStrongEnough($a);
    }

    final public function testUserIsActive(): void
    {
        $user = new User();
        $user->setActive();
        self::assertTrue($user->isActive());
    }

    final public function testUserIsInactive(): void
    {
        $user = new User();
        self::assertFalse($user->isActive());
    }

    final public function testUserActivatedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->setActive();
        self::assertGreaterThan($user->createdAt(), $user->activatedAt());
    }

    final public function testUserIsDeleted(): void
    {
        $user = new User();
        $user->delete();
        self::assertTrue($user->isDeleted());
    }

    final public function testUserIsNotDeleted(): void
    {
        $user = new User();
        self::assertFalse($user->isDeleted());
    }

    final public function testUserDeletedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->delete();
        self::assertGreaterThan($user->createdAt(), $user->deletedAt());
    }

    /** @return  array<int, array<int, string>> */
    public function passProvider(): array
    {
        return [
            ['1A'],
            ['serkobtjqe^ritjqàtjkq)$oh5nzterkn$aqzerkt^=$penprtkngq^^$erkytnq$êr'],
            ['1232315468785465432134564'],
            ['qsdfqsdfqsdfzeraz'],
            ['          ']
        ];
    }
}
