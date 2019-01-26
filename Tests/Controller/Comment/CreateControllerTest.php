<?php

namespace App\Tests\Controller\Comment;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateControllerTest extends WebTestCase
{
    public function testCreateComment()
    {
        $client = static::createClient();

        $client->request('GET', '/comment/create');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
