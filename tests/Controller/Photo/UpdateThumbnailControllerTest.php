<?php

namespace App\Tests\Controller\Photo;

use App\Tests\Controller\Traits\FakeAuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateThumbnailControllerTest extends WebTestCase
{
    use FakeAuthenticationTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testUpdateThumbnailPhoto()
    {
        $this->logIn();

        $this->client->request('GET', '/photo/update-thumbnail/5');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
