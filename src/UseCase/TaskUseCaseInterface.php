<?php

namespace App\UseCase;

use App\Entity\Task;

interface TaskUseCaseInterface
{
    public function createAction(Task $task);

    public function editAction(Task $task);

    public function toggleAction(Task $task);

    public function deleteAction(Task $task);
}
