<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $hash = $this->hasher->hashPassword($user, 'admin');
        $user
            ->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        for ($u = 1; $u <= 5; ++$u) {
            $user = new User();

            $hash = $this->hasher->hashPassword($user, 'password');

            $user
                ->setUsername("user{$u}")
                ->setEmail("user{$u}@gmail.com")
                ->setPassword($hash);

            $manager->persist($user);

            for ($t = 1; $t <= rand(1, 4); ++$t) {
                $task = new Task();

                $task
                    ->setTitle("task {$t}")
                    ->setContent("Content task {$t}")
                    ->setUser($user);

                $manager->persist($task);
            }
        }

        $manager->flush();
    }
}
