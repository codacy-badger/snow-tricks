<?php

namespace App\Tests\Controller\Trick;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testListTrick()
    {
        $this->client->request('GET', '/all-tricks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}
