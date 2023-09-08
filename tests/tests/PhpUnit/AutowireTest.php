<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests: Autowire
 */
class AutowireTest extends WebTestCase
{
    public function testAutowire(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get_autowire/test');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'test => value');
    }
}
