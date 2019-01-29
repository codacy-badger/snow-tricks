<?php

namespace App\Tests\Controller\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogoutControllerTest extends WebTestCase
{
    public function testLogoutUser()
    {
        $client = static::createClient();

        $client->request('GET', '/user/logout');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
