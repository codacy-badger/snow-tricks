<?php

namespace App\Tests\Controller\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testUserLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/user/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
