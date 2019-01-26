<?php

namespace App\Tests\Controller\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignupControllerTest extends WebTestCase
{
    public function testSignupUser()
    {
        $client = static::createClient();

        $client->request('GET', '/user/signup');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
