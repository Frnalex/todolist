<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const DELETE = 'delete';

    private Security $security;

    public function __construct(
        Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $task): bool
    {
        return in_array($attribute, [self::DELETE]) && $task instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($task, $user);
                break;
        }

        return false;
    }

    private function canDelete(Task $task, User $user): bool
    {
        if ($task->getUser() === $user) {
            return true;
        } elseif (null === $task->getUser() && $this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }
}
