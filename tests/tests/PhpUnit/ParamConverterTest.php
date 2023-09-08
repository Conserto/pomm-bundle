<?php

namespace App\Tests\Phpunit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests: Entity Param Converter
 */
class ParamConverterTest extends WebTestCase
{
    public function testGetTest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get/test');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'test => value2');
    }

    public function testGet(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'config => null');
    }

    public function testGetSessionDefaultTest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get_session_default/test');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'test => value');
    }

    public function testGetSession1Test(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get_session_1/test');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'test => value');
    }

    public function testGetSession2Test(): void
    {
        $client = static::createClient();
        $client->request('GET', '/get_session_1/test');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'test => value_db2');
    }
}
