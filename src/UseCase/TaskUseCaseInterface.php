<?php

namespace App\UseCase;

use App\Entity\Task;

interface TaskUseCaseInterface
{
    public function createAction(Task $task): void;

    public function editAction(Task $task): void;

    public function toggleAction(Task $task): void;

    public function deleteAction(Task $task): void;
}
