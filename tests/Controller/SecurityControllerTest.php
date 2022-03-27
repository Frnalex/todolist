<?php

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testDisplayLogin()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorNotExists('alert alert-danger');
    }

    public function testLoginSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'user1',
            '_password' => 'password',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('homepage');
    }

    public function testLoginFail()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'badUsername',
            '_password' => 'badPassword',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('login');
    }

    public function testLogout()
    {
        $client = static::createAuthenticatedClient();

        $client->request(Request::METHOD_GET, '/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('homepage');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('login');
    }
}
