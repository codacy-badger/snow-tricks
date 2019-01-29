<?php

namespace App\Tests\Controller\Trick;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testDeleteTrick()
    {
        $this->logIn();

        $this->client->request('GET', '/trick/edit/china-air');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
