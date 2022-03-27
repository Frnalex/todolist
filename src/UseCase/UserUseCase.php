<?php

namespace App\UseCase;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUseCase implements UserUseCaseInterface
{
    private $entityManager;
    private $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    public function createAction(User $user)
    {
        $hash = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function editAction(User $user)
    {
        $hash = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);

        $this->entityManager->flush();
    }
}
