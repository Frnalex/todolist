<?php

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testUserIsNotLoggedIn()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testUserIsLoggedIn()
    {
        $client = static::createAuthenticatedClient();

        // test e.g. the profile page
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
