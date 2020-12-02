<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
use DateTime;
use DateTimeInterface;
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
        $user->suspended();
        $this->assertGreaterThan($user->createdAt(), $user->suspendedAt());
    }

    final public function testDateCreatedAt(): void
    {
        $user = new User();
        sleep(1);

        $this->assertGreaterThan($user->createdAt(), new DateTime());
    }
}
