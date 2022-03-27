<?php

namespace App\UseCase;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUseCase implements UserUseCaseInterface
{
    private $em;
    private $hasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $this->em = $em;
        $this->hasher = $hasher;
    }

    public function createAction(User $user)
    {
        $hash = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function editAction(User $user)
    {
        // code...
    }
}
