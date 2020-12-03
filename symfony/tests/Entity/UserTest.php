<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Exception\InvalidEmailException;
use App\Exception\InvalidTimeZone;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    final public function testConstructor(): void
    {
        $user = new User();

        self::assertInstanceOf(User::class, $user);
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

    final public function testValidTimeZone(): void
    {
        $user = new User();
        $timezone = 'Europe/Paris';

        $user->setTimeZone($timezone);

        self::assertSame($timezone, $user->getTimeZone());
    }

    final public function testInvalidTimeZone(): void
    {
        $user = new User();
        $timezone = 'Random/Truc';

        self::expectException(InvalidTimeZone::class);
        $user->setTimeZone($timezone);
    }


    //TODO A finir  d'urgence
    final public function testUserBirthDate(): void
    {
        $user = new User();
        $user->setBirthDate(new DateTime("2000-06-12"));

        self::assertTrue($user->isUserOldEnough());
    }

//    final public function testUserIsOldEnough(): void
//    {
//        $user = new User();
//        $user->setBirthDate(
//            (new DateTime("2000-06-12"))
//                ->setTimezone(new DateTimeZone('Europe/Paris'))
//        );
//
//        self::assertTrue($user->isUserOldEnough());
//    }

//    /**
//     * @throws Exception
//     */
//    final public function testUserIsNotOldEnough(): void
//    {
//        $user = new User();
//        $tenYearsAgo = (new DateTime())
//            ->sub(new DateInterval('P10Y'))
//            ->setTimezone(new DateTimeZone('Europe/Paris'))
//            ->setTime(0, 0);
//
//        $user->setBirthDate($tenYearsAgo);
//
//        self::assertFalse($user->isUserOldEnough());
//    }
}
