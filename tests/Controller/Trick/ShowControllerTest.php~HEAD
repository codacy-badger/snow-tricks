<?php

namespace App\Tests\Controller\Trick;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testShowTrick()
    {
        $this->logIn();

        $this->client->request('GET', '/trick/show/crail');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
