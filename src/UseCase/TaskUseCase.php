<?php

namespace App\UseCase;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskUseCase implements TaskUseCaseInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createAction(Task $task)
    {
        $this->em->persist($task);
        $this->em->flush();
    }

    public function editAction(Task $task)
    {
        //     $hash = $this->hasher->hashPassword($user, $user->getPassword());
    //     $user->setPassword($hash);

    //     $this->em->flush();
    }
}
