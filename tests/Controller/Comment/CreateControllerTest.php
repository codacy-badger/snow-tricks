<?php

namespace App\Tests\Controller\Comment;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testCreateComment()
    {
        $this->logIn();

        $this->client->request('GET', '/trick/china-air/comment/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
