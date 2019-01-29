<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteControllerTest extends WebTestCase
{
    public function testDeleteTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/trick/delete/japan-air');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
