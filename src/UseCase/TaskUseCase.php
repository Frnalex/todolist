<?php

namespace App\UseCase;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskUseCase implements TaskUseCaseInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAction(Task $task)
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function editAction(Task $task)
    {
        $this->entityManager->flush();
    }

    public function toggleAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();
    }

    public function deleteAction(Task $task)
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
