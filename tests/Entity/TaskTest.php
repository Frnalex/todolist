<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function getEntity(): Task
    {
        return (new Task())
            ->setTitle('Title')
            ->setContent('Lorem ipsum, dolor sit amet')
        ;
    }

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($task);
        $this->assertCount($number, $errors);
    }

    public function testEntityIsValid()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testEntityIsNotValid()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 1);
        $this->assertHasErrors($this->getEntity()->setContent(''), 1);
    }
}
