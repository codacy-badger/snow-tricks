<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListControllerTest extends WebTestCase
{
    public function testListTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/all-tricks');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
