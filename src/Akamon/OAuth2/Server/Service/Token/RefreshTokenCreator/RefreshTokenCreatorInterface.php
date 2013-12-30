<?php

namespace Akamon\OAuth2\Server\Service\Token\RefreshTokenCreator;

use Akamon\OAuth2\Server\Model\RefreshToken\RefreshToken;

interface RefreshTokenCreatorInterface
{
    /**
     * @return RefreshToken
     */
    function create($accessTokenTokenToken);
}
