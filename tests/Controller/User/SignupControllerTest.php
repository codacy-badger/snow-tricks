<?php

namespace App\Tests\Controller\User;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignupControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSignupUser()
    {
        $this->client->request('GET', '/user/sign-up');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
