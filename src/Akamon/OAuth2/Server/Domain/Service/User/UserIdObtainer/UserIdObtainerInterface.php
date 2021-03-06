<?php

namespace Akamon\OAuth2\Server\Domain\Service\User\UserIdObtainer;

use Akamon\OAuth2\Server\Domain\Exception\UserNotFoundException;

interface UserIdObtainerInterface
{
    /**
     * @return string
     *
     * @throws UserNotFoundException
     */
    function getUserId($username);
}
