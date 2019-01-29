<?php

namespace App\Tests\Controller\Trick;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RemoveVideoControllerTest extends WebTestCase
{
    public function testRemoveVideoTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/trick/japan-air/video/1/delete');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
