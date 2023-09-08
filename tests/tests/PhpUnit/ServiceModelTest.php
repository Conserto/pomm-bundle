<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests: Entity Serialization
 */
class ServiceModelTest extends WebTestCase
{
    public function testServiceModel(): void
    {
        $client = static::createClient();
        $client->request('GET', '/serviceModel');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Created model as service. Sum:2');
    }

    public function testServiceContainer(): void
    {
        $client = static::createClient();
        $client->request('GET', '/serviceContainer');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Model from container as service. Sum:2');
    }
}
