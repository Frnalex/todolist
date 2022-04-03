<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait AuthenticationTrait
{
    public static function createAuthenticatedClient(): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'user1']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        return $client;
    }

    public static function createAuthenticatedClientAdmin(): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testAdmin = $userRepository->findOneBy(['username' => 'admin']);

        // simulate $testUser being logged in
        $client->loginUser($testAdmin);

        return $client;
    }

}
