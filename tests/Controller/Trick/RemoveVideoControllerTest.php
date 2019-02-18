<?php

namespace App\Tests\Controller\Trick;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RemoveVideoControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testRemoveVideoTrick()
    {
        $this->logIn();

        $this->client->request('GET', '/trick/china-air/video/1/delete');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}
