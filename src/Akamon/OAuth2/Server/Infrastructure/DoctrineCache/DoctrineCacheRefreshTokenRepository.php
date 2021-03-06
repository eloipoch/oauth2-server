<?php

namespace Akamon\OAuth2\Server\Infrastructure\DoctrineCache;

use Akamon\OAuth2\Server\Domain\Model\RefreshToken\RefreshToken;
use Akamon\OAuth2\Server\Domain\Model\RefreshToken\RefreshTokenRepositoryInterface;
use Doctrine\Common\Cache\Cache;
use felpado as f;

class DoctrineCacheRefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function add(RefreshToken $refreshToken)
    {
        $token = f\get($refreshToken, 'token');
        $params = $refreshToken->getParams();
        $lifetime = f\get($refreshToken, 'lifetime');

        return $this->cache->save($token, $params, $lifetime);
    }

    public function remove(RefreshToken $refreshToken)
    {
        return $this->cache->delete(f\get($refreshToken, 'token'));
    }

    public function find($token)
    {
        $params = $this->cache->fetch($token);

        return $params ? new RefreshToken($params) : null;
    }
}
