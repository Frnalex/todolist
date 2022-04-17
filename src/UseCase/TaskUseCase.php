<?php

namespace App\UseCase;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskUseCase implements TaskUseCaseInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAction(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function editAction(Task $task): void
    {
        $this->entityManager->flush();
    }

    public function toggleAction(Task $task): void
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();
    }

    public function deleteAction(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
