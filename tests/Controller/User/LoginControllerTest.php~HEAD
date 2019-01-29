<?php

namespace App\Tests\Controller\User;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testUserLogin()
    {
        $this->client->request('GET', '/user/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
