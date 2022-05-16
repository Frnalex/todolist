<?php

namespace App\UseCase;

use App\Entity\User;

interface UserUseCaseInterface
{
    public function createAction(User $user): void;

    public function editAction(User $user): void;

    public function resetPasswordAction(User $user): void;
}
