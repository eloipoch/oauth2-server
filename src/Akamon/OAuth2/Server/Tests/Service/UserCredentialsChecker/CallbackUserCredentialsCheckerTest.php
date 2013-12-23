<?php

namespace Akamon\OAuth2\Server\Tests\Service\UserCredentialsChecker;

use Akamon\OAuth2\Server\Model\UserCredentials;
use Akamon\OAuth2\Server\Service\UserCredentialsChecker\CallbackUserCredentialsChecker;
use Akamon\OAuth2\Server\Tests\OAuth2TestCase;

class CallbackUserCredentialsCheckerTest extends OAuth2TestCase
{
    public function testCheck()
    {
        $pablodipCredentials = new UserCredentials('pablodip', 'pass');
        $callback = function (UserCredentials $userCredentials) use ($pablodipCredentials) {
            return $userCredentials == $pablodipCredentials;
        };
        $checker = new CallbackUserCredentialsChecker($callback);

        $this->assertTrue($checker->check(new UserCredentials('pablodip', 'pass')));
        $this->assertFalse($checker->check(new UserCredentials('pablodip', 'no')));
        $this->assertFalse($checker->check(new UserCredentials('foo', 'no')));
    }
}
