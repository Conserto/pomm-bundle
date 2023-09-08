<?php

namespace App\Tests\Phpunit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests: Entity Param Converter
 */
class PropertyInfoTest extends WebTestCase
{
    public function testPropertyList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/property');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'name/value');
    }

    public function testPropertyType(): void
    {
        $client = static::createClient();
        $client->request('GET', '/property/name');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'string');
    }
}
