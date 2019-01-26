<?php

namespace App\Tests\Controller\Photo;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteControllerTest extends WebTestCase
{
    public function testDeletePhoto()
    {
        $client = static::createClient();

        $client->request('GET', '/photo/delete/1');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
