<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests: Entity Serialization
 */
class SerializerTest extends WebTestCase
{
    public function testSerialize(): void
    {
        $client = static::createClient();
        $client->request('GET', '/serialize');
        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertEquals('[{"point":{"x":1.0,"y":2.0}}]', $response->getContent());
    }
}
