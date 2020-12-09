<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Exception\InvalidFirstNameException;
use App\Exception\InvalidLastNameException;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class UserTest extends WebTestCase
{
    private function getKernel(): KernelInterface
    {
        $kernel = $this->bootKernel();
        $kernel->boot();
        return $kernel;
    }

    public function testConstructor(): void
    {
        $user = new User();

        $this->assertInstanceOf(User::class, $user);
        $this->assertLessThanOrEqual(new DateTime(), $user->createdAt());
    }

    public function testValidEmail(): void
    {
        $user = new User();
        $email = "mail-address@mail.com";

        $user->setEmail($email);

        $this->assertSame($email, $user->getEmail());
    }

    public function testInvalidEmail(): void
    {
        $user = new User();
        $email = "mîiladøïress@ma@il.com";

        $this->expectException(InvalidEmailException::class);
        $user->setEmail($email);
    }

    public function testValidTimeZone(): void
    {
        $user = new User();
        $timezone = 'Europe/Paris';

        $user->setTimeZone($timezone);

        $this->assertSame($timezone, $user->getTimeZone());
    }

    public function testInvalidTimeZone(): void
    {
        $user = new User();
        $timezone = 'Random/Truc';

        $this->expectException(InvalidTimeZone::class);
        $user->setTimeZone($timezone);
    }

    public function testSetLastName(): void
    {
        $lastName = "PARMENTIER";
        $user = new User();
        $user->setLastName($lastName);

        $this->assertSame($lastName, $user->getLastName());
    }

    public function testSetInvalidLastName(): void
    {
        $user = new User();

        $this->expectException(InvalidLastNameException::class);
        $user->setLastName("@%45");
    }

    public function testSetFirstName(): void
    {
        $firstName = "PARMENTIER";
        $user = new User();
        $user->setFirstName($firstName);

        $this->assertSame($firstName, $user->getFirstName());
    }

    public function testSetInvalidFirstName(): void
    {
        $user = new User();

        $this->expectException(InvalidFirstNameException::class);
        $user->setFirstName("@%45");
    }

    public function testUserSuspendedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->suspend();
        $this->assertGreaterThan($user->createdAt(), $user->suspendedAt());
    }

    public function testUserIsNotSuspended(): void
    {
        $user = new User();
        $this->assertFalse($user->isSuspended());
    }

    public function testDateCreatedAt(): void
    {
        $user = new User();
        sleep(1);

        $this->assertGreaterThan($user->createdAt(), new DateTime());
    }

    public function testPassWordIsValid(): void
    {
        $user = new User();
        $this->assertTrue($user->setPassword('1AAZDSQDq'));
    }

    /** @dataProvider passProvider */
    public function testPassWordIsInvalid(string $a): void
    {
        $user = new User();
        $this->expectException(InvalidArgumentException::class);
        $user->isPasswordStrongEnough($a);
    }

    public function testUserIsActive(): void
    {
        $user = new User();
        $user->setActive();
        $this->assertTrue($user->isActive());
    }

    public function testUserIsInactive(): void
    {
        $user = new User();
        $this->assertFalse($user->isActive());
    }

    public function testUserActivatedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->setActive();
        $this->assertGreaterThan($user->createdAt(), $user->activatedAt());
    }

    public function testUserIsDeleted(): void
    {
        $user = new User();
        $user->delete();
        $this->assertTrue($user->isDeleted());
    }

    public function testUserIsNotDeleted(): void
    {
        $user = new User();
        $this->assertFalse($user->isDeleted());
    }

    public function testUserDeletedAt(): void
    {
        $user = new User();
        sleep(1);
        $user->delete();
        $this->assertGreaterThan($user->createdAt(), $user->deletedAt());
    }

    /** @return array<array<string>> */
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

    public function testUserIsOldEnough(): void
    {
        $user = new User();
        $user->setBirthDate(
            (new DateTime("2000-06-12"))
                ->setTimezone(new DateTimeZone('Europe/Paris'))
        );

        $this->assertTrue($user->isUserOldEnough());
    }

    /**
     * @dataProvider invalidBirthDate
     * @throws Exception
     */
    public function testUserIsNotOldEnough(DateTime $invalidBirthDate): void
    {
        $user = new User();
        $user->setBirthDate($invalidBirthDate);

        $this->assertFalse($user->isUserOldEnough());
    }

    /** @return array<array<DateTime>> */
    public function invalidBirthDate(): array
    {
        return [
            [
                new DateTime()
            ],
            [
                (new DateTime())
                    ->sub(new DateInterval('P10Y'))
                    ->setTimezone(new DateTimeZone('Europe/Paris'))
                    ->setTime(0, 0)
            ],
            [
                (new DateTime())
                    ->sub(new DateInterval('P17Y11M'))
                    ->setTimezone(new DateTimeZone('Europe/Paris'))
                    ->setTime(0, 0)
            ],
            [
                (new DateTime())
                    ->sub(new DateInterval('P15Y'))
                    ->setTimezone(new DateTimeZone('Europe/Paris'))
                    ->setTime(0, 0)
            ],
        ];
    }
}
