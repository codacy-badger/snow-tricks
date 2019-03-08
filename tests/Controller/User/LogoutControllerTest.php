<?php

namespace App\Tests\Controller\User;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogoutControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testUserLogout()
    {
        $this->logIn();

        $this->client->request('GET', '/user/logout');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
