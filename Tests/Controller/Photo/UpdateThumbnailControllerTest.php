<?php

namespace App\Tests\Controller\Photo;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateThumbnailControllerTest extends WebTestCase
{
    public function testUpdateThumbnailPhoto()
    {
        $client = static::createClient();

        $client->request('GET', '/photo/update-thumbnail/1');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
}
