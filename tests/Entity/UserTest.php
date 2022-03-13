<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): User
    {
        $user = (new User())
            ->setUsername('user')
            ->setPassword('password')
            ->setEmail('test@gmail.com')
            ;

        return $user;
    }

    public function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($user);
        $this->assertCount($number, $errors);
    }

    public function testEntityIsValid()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testEntityIsNotValid()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('emailnotvalid'), 1);
    }

    public function testEntityIsNotUnique()
    {
        $this->databaseTool->loadFixtures(['App\DataFixtures\UserFixtures']);
        $this->assertHasErrors($this->getEntity()->setEmail('user1@gmail.com'), 1);
        $this->assertHasErrors($this->getEntity()->setUsername('user1'), 1);
    }
}
