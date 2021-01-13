<?php

namespace App\DataFixtures;

use _HumbugBoxbde535255540\Nette\Utils\DateTime;
use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 1; $i++) {
            $user = new User();
            $user->setWallet(new Wallet());
            $user->setUsername('Test' . $i);
            $user->setEmail('test' . $i . '@test.com');
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
        }
        $manager->flush();
    }
}
