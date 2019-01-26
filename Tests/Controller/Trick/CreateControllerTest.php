<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateControllerTest extends WebTestCase
{
    public function testCreateTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/trick/create');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
