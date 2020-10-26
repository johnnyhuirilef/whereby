<?php

namespace Enius\Whereby;

use Enius\Whereby\Exception\AccessTokenMissingException;
use Enius\Whereby\Exception\ResponseStatusCodeError;
use Enius\Bitly\Provider\V3\V3;
use Enius\Bitly\Provider\V4\V4;
use Enius\Whereby\Provider\V1\V1;
use Psr\Http\Message\ResponseInterface;

class Whereby
{
    private $token = null;
    private $v1;
    const BASE_URL = 'https://api.whereby.dev';

    /**
     * @param $token
     * @return Whereby
     * @throws AccessTokenMissingException
     */
    static function get($token)
    {
        return new static($token);
    }

    /**
     * Client constructor.
     * @param $token
     * @throws AccessTokenMissingException
     */
    public function __construct($token)
    {
        $this->checkEmptyToken($token);
        $this->token = $token;
    }

    /**
     * @return V1
     */
    public function v1()
    {
        if (!$this->v1 instanceof V1) {
            $this->v1 = V1::get($this->token);
        }

        return $this->v1;
    }

    static function getBaseUri($version)
    {
        return self::BASE_URL . '/' . $version . '/';
    }

    /**
     * @param $token
     * @throws AccessTokenMissingException
     */
    private function checkEmptyToken($token): void
    {
        if (empty($token)) {
            throw new AccessTokenMissingException('Access token is not set');
        }
    }

    /**
     * @param ResponseInterface $response
     * @throws ResponseStatusCodeError
     */
    static function checkResponseStatusCodeError(ResponseInterface $response): void
    {
        if (!in_array($response->getStatusCode(), [200, 201, 204])) {
            throw new ResponseStatusCodeError('Whereby Status Code:' . $response->getStatusCode() . " - " . $response->getStatusResponse());
        }
    }
}
