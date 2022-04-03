<?php

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testListAction()
    {
        $client = static::createAuthenticatedClientAdmin();
        $client->request(Request::METHOD_GET, '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListActionNotAuthorized()
    {
        $client = static::createAuthenticatedClient();
        $client->request(Request::METHOD_GET, '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDisplayCreateForm()
    {
        $client = static::createAuthenticatedClientAdmin();
        $client->request(Request::METHOD_GET, '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('form');
    }

    public function testCreateAction()
    {
        $client = static::createAuthenticatedClientAdmin();
        $crawler = $client->request(Request::METHOD_GET, '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'new-user',
            'user[password][first]' => 'new-password',
            'user[password][second]' => 'new-password',
            'user[email]' => 'new-user@test.com',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('user_list');
    }

    public function testCreateActionNotAuthorized()
    {
        $client = static::createAuthenticatedClient();
        $client->request(Request::METHOD_GET, '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testEditAction()
    {
        $client = static::createAuthenticatedClientAdmin();
        $crawler = $client->request(Request::METHOD_GET, '/users/1/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'user-update',
            'user[password][first]' => 'password-update',
            'user[password][second]' => 'password-update',
            'user[email]' => 'update@test.com',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('user_list');
    }
}
