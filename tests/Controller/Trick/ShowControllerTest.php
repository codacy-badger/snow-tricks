<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowControllerTest extends WebTestCase
{
    public function testShowTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/trick/show/japan-air');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
