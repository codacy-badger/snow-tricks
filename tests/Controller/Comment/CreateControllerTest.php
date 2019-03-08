<?php

namespace App\Tests\Controller\Comment;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testCreateComment()
    {
        $this->logIn();

        $this->client->request('GET', '/trick/crail/comment/create');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertTrue($this->client->getResponse()->isRedirect('/trick/crail'));
    }
}
