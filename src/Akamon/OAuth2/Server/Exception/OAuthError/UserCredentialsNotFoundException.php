<?php

namespace Akamon\OAuth2\Server\Exception\OAuthError;

use Akamon\OAuth2\Server\Exception\OAuthError\InvalidRequestOAuthErrorException;

class UserCredentialsNotFoundException extends InvalidRequestOAuthErrorException
{
    public function __construct()
    {
        parent::__construct('The user credentials are required.');
    }
}