<?php

namespace App\Tests\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Security\Voter\TaskVoter;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProjectVoterTest extends TestCase
{
    public function testVoteWhenTaskAuthorIsUserLogged()
    {
        $security = $this->createMock(Security::class);
        $voter = new TaskVoter($security);

        /** @var MockObject|TokenInterface */
        $token = $this->createMock(TokenInterface::class);
        $user = new User();
        $token->method('getUser')->willReturn($user);

        $task = new Task();
        $task->setUser($user);

        $this->assertEquals(TaskVoter::ACCESS_GRANTED, $voter->vote($token, $task, [TaskVoter::DELETE]));
    }

    public function testVoteWhenTaskAuthorIsNullAndUserIsAdmin()
    {
        /** @var MockObject|AuthorizationCheckerInterface */
        $security = $this->createMock(Security::class);
        $security->method('isGranted')->willReturn(true);
        $voter = new TaskVoter($security);

        /** @var MockObject|TokenInterface */
        $token = $this->createMock(TokenInterface::class);
        $user = new User();
        $token->method('getUser')->willReturn($user);

        $task = new Task();
        $task->setUser(null);

        $this->assertEquals(TaskVoter::ACCESS_GRANTED, $voter->vote($token, $task, [TaskVoter::DELETE]));
    }

    public function testVoteWhenTaskAuthorIsNotUserLogged()
    {
        $security = $this->createMock(Security::class);
        $voter = new TaskVoter($security);

        /** @var MockObject|TokenInterface */
        $token = $this->createMock(TokenInterface::class);
        $user = new User();
        $token->method('getUser')->willReturn($user);

        $user2 = new User();
        $task = new Task();
        $task->setUser($user2);
        
        $this->assertEquals(TaskVoter::ACCESS_DENIED, $voter->vote($token, $task, [TaskVoter::DELETE]));
    }

    public function testVoteWhenUserIsNotUserInterface()
    {
        $security = $this->createMock(Security::class);
        $voter = new TaskVoter($security);

        /** @var MockObject|TokenInterface */
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn(null);

        $task = new Task();
        
        $this->assertEquals(TaskVoter::ACCESS_DENIED, $voter->vote($token, $task, [TaskVoter::DELETE]));
    }

    // public function testVoteWhenAttributeDoesNotExist()
    // {
    //     $security = $this->createMock(Security::class);
    //     $voter = new TaskVoter($security);

    //     /** @var MockObject|TokenInterface */
    //     $token = $this->createMock(TokenInterface::class);
    //     $user = new User();
    //     $token->method('getUser')->willReturn($user);

    //     $task = new Task();
    //     $task->setUser($user);
        
    //     $this->assertEquals(TaskVoter::ACCESS_DENIED, $voter->vote($token, $task, ['this-attribute-does-not-exist', 'delete']));
    // }
}
