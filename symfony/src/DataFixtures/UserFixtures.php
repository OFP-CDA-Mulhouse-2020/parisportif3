<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wallet;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setWallet(new Wallet());
        $user->setUsername('Test');
        $user->setEmail('test@test.com');
        $user->setBirthDate((new DateTime())->setDate(1995, 02, 15));
        $user->setFirstName('Jean-Michele');
        $user->setLastName('Dupont');
        $user->setPassword(
            $this->encoder->encodePassword(
                $user,
                'correct horse battery staple'
            )
        );

        $manager->persist($user);
        $manager->flush();
    }
}
