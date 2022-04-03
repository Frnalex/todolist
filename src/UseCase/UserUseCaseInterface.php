<?php

namespace App\UseCase;

use App\Entity\User;

interface UserUseCaseInterface
{
    public function createAction(User $user);

    public function editAction(User $user);

    public function resetPasswordAction(User $user);
}
