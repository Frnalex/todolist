<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($u = 1; $u <= 5; ++$u) {
            $user = new User();

            $hash = $this->hasher->hashPassword($user, 'password');

            $user
                ->setUsername("user{$u}")
                ->setEmail("user{$u}@gmail.com")
                ->setPassword($hash)
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
