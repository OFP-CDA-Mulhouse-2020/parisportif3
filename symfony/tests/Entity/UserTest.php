<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
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

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(DateTimeInterface::class, $user->createdAt());
        $this->assertLessThanOrEqual(new DateTime(), $user->createdAt());
    }

    final public function testUserBirthDate(): void
    {
        $user = new User();
        $user->setBirthDate(new DateTime("2000-06-12"));

        $this->assertTrue($user->isUserOldEnough());
    }

    final public function testSetLastName(): void
    {
        $lastName = "PARMENTIER";
        $user = new User();
        $user->setLastName($lastName);

        $this->assertSame($lastName, $user->getLastName());
    }

    final public function testSetInvalidLastName(): void
    {
        $user = new User();

        $this->expectException(InvalidLastNameException::class);
        $user->setLastName("@%45");
    }

    final public function testSetFirstName(): void
    {
        $firstName = "PARMENTIER";
        $user = new User();
        $user->setFirstName($firstName);

        $this->assertSame($firstName, $user->getFirstName());
    }

    final public function testSetInvalidFirstName(): void
    {
        $user = new User();

        $this->expectException(InvalidFirstNameException::class);
        $user->setFirstName("@%45");
    }

    final public function testUserSuspendedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->suspend();
        $this->assertGreaterThan($user->createdAt(), $user->suspendedAt());
    }

    final public function testUserIsNotSuspended(): void
    {
        $user = new User();
        $this->assertFalse($user->isSuspended());
    }

    final public function testDateCreatedAt(): void
    {
        $user = new User();
        sleep(1);

        $this->assertGreaterThan($user->createdAt(), new DateTime());
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
