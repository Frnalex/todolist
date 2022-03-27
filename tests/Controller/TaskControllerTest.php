<?php

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testListAction()
    {
        $client = static::createAuthenticatedClient();
        $client->request(Request::METHOD_GET, '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateAction()
    {
        $client = static::createAuthenticatedClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Lorem, ipsum.',
            'task[content]' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam, numquam!',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('task_list');
    }

    public function testEditAction()
    {
        $client = static::createAuthenticatedClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks/1/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Titre modifié',
            'task[content]' => 'Contenu modifié',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('task_list');
    }

    public function testToggleAction()
    {
        $client = static::createAuthenticatedClient();
        $client->request(Request::METHOD_GET, '/tasks/1/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('task_list');
    }

    public function testDeleteAction()
    {
        $client = static::createAuthenticatedClient();
        $client->request(Request::METHOD_GET, '/tasks/1/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('task_list');
    }
}
