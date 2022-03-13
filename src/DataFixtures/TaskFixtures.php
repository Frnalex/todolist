<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($t = 1; $t <= 5; ++$t) {
            $task = new Task();

            $task
                ->setTitle("task {$t}")
                ->setContent("Content task {$t}")
            ;

            $manager->persist($task);
        }

        $manager->flush();
    }
}
