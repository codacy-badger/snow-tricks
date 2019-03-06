<?php

namespace App\Tests\Controller\Photo;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testDeletePhoto()
    {
        $this->logIn();

        $this->client->request('GET', '/photo/delete/3');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
