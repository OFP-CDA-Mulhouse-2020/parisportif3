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

    /**
     * @dataProvider provider
     */
    final public function testPassWordIsInvalid($a): void
    {
        self::expectException(InvalidArgumentException::class);
        User::isPasswordStrongEnough($a);
    }

    final public function testUserIsActive(): void
    {
        $user = new User();
        $user->setActive();
        $array = $user->isActive();
        self::assertTrue($array['state']);
    }

    final public function testUserIsInactive(): void
    {
        $user = new User();
        $array = $user->isActive();
        self::assertFalse($array['state']);
    }

    final public function testUserActivatedAt(): void
    {
        $user = new User();
        sleep(2);
        $user->setActive();
        $array = $user->isActive();
        self::assertGreaterThan($user->createdAt(), $array['date']);
    }

    final public function testUserIsDeleted(): void
    {
        $user = new User();
        $array = $user->isDeleted();
        self::assertFalse($array['state']);
    }

    final public function testUserDeletedAt(): void
    {
        $user = new User();
        sleep(2);
        $user->delete();
        $array = $user->isDeleted();
        self::assertGreaterThan($user->createdAt(), $array['date']);
    }

    public function provider()
    {
        return array(
            ['1A'],
            ['serkobtjqe^ritjqàtjkq)$oh5nzterkn$aqzerkt^=$penprtkngq^^$erkytnq$êr'],
            ['1232315468785465432134564'],
            ['qsdfqsdfqsdfzeraz'],
            ['          ']
        );
    }
}
