<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditControllerTest extends WebTestCase
{
    public function testEditTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/trick/edit/japan-air');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
