<?php

namespace Akamon\OAuth2\Server\Domain\Tests\Service\Token\TokenGranter;

use Akamon\OAuth2\Server\Domain\Service\Token\TokenGranter\TokenGranterByGrantType;
use Akamon\OAuth2\Server\Domain\Tests\OAuth2TestCase;
use Symfony\Component\HttpFoundation\Request;
use Mockery\MockInterface;

class TokenGranterByGrantTypeTest extends OAuth2TestCase
{
    /** @var MockInterface */
    private $clientObtainer;

    /** @var MockInterface */
    private $processorCode;
    /** @var MockInterface */
    private $processorPassword;

    /** @var TokenGranterByGrantType */
    private $granter;

    protected function setUp()
    {
        $this->clientObtainer = $this->mock('Akamon\OAuth2\Server\Domain\Service\Client\ClientObtainer\ClientObtainerInterface');

        $this->processorCode = $this->createProcessorMock();
        $this->processorPassword = $this->createProcessorMock();

        $processors = [
            'code' => $this->processorCode,
            'password' => $this->processorPassword
        ];

        $this->granter = new TokenGranterByGrantType($this->clientObtainer, $processors);
    }

    private function createProcessorMock()
    {
        return $this->mock('Akamon\OAuth2\Server\Domain\Service\Token\TokenGrantTypeProcessor\TokenGrantTypeProcessorInterface');
    }

    public function testGrantOk()
    {
        $inputData = ['a' => 1, 'b' => 2];
        $request = $this->createRequestForGrantType('password');
        $request->request->add($inputData);
        $response = new \stdClass();

        $client = $this->createClient(['allowedGrantTypes' => ['password']]);
        $this->clientObtainer->shouldReceive('getClient')->with($request)->once()->andReturn($client);

        $this->processorPassword->shouldReceive('process')->once()->with($client, $inputData)->andReturn($response);

        $this->assertSame($response, $this->granter->grant($request));
    }

    /**
     * @expectedException \Akamon\OAuth2\Server\Domain\Exception\OAuthError\GrantTypeNotFoundOAuthErrorException
     */
    public function testGrantShouldThrowAnGrantTypeNotFoundException()
    {
        $request = new Request();

        $client = $this->createClient();
        $this->clientObtainer->shouldReceive('getClient')->with($request)->once()->andReturn($client);

        $this->granter->grant($request);
    }

    /**
     * @expectedException \Akamon\OAuth2\Server\Domain\Exception\OAuthError\UnsupportedGrantTypeOAuthErrorException
     */
    public function testGrantShouldThrowAnUnsupportedGrantTypeException()
    {
        $request = $this->createRequestForGrantType('no');

        $client = $this->createClient(['allowedGrantTypes' => ['no']]);
        $this->clientObtainer->shouldReceive('getClient')->with($request)->once()->andReturn($client);

        $this->granter->grant($request);
    }

    private function createRequestForGrantType($grantType)
    {
        $query = [];
        $request = ['grant_type' => $grantType];

        return new Request($query, $request);
    }
}
