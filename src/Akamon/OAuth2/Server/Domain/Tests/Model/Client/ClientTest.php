<?php

namespace Akamon\OAuth2\Server\Domain\Tests\Model\Client;

use Akamon\OAuth2\Server\Domain\Model\Client\Client;
use felpado as f;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testClientConstructor()
    {
        $client = new Client('pablodip');

        $this->assertSame('pablodip', f\get($client, 'name'));
    }

    public function testConstructorMinimumParameters()
    {
        $name = 'pablodip';
        $client = new \Akamon\OAuth2\Server\Domain\Model\Client\Client(['name' => $name]);

        $this->assertSame([
            'id' => null,
            'name' => 'pablodip',
            'secret' => null,
            'allowedGrantTypes' => array(),
            'allowedScopes' => array(),
            'defaultScope' => null
        ], $client->getParams());
    }

    public function testConstructorFullParameters()
    {
        $params = [
            'id' => 1,
            'name' => 'pablodip',
            'secret' => 'foo',
            'allowedGrantTypes' => array('password'),
            'allowedScopes' => array('read'),
            'defaultScope' => 'bar'
        ];

        $client = new \Akamon\OAuth2\Server\Domain\Model\Client\Client($params);
        $this->assertSame($params, $client->getParams());
    }

    public function testCheckSecretShouldReturnTrueWhenTheSecretIsRight()
    {
        $client = new Client(['name' => 'pablodip', 'secret' => '123']);

        $this->assertTrue($client->checkSecret('123'));
    }

    public function testCheckSecretShouldReturnFalseWhenTheSecretIsNotRight()
    {
        $client = new Client(['name' => 'pablodip', 'secret' => '123']);

        $this->assertFalse($client->checkSecret('321'));
    }

    public function testHasAllowedGrantType()
    {
        $client = new Client(['name' => 'pablodip', 'allowedGrantTypes' => ['foo']]);

        $this->assertTrue($client->hasAllowedGrantType('foo'));
        $this->assertFalse($client->hasAllowedGrantType('bar'));
    }

    public function testHasAllowedScope()
    {
        $client = new Client(['name' => 'pablodip', 'allowedScopes' => ['foo']]);

        $this->assertTrue($client->hasAllowedScope('foo'));
        $this->assertFalse($client->hasAllowedScope('bar'));
    }
}
