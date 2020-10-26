<?php


namespace Enius\Whereby\Provider\V1;

use Enius\Whereby\Provider\V1\Resource\Meeting;

use Enius\Whereby\Whereby;

class V1
{
    const VERSION = 'v1';
    private $client;
    public $meeting;

    /**
     * @param $token
     * @param array $defaultConfig
     * @return V1
     */
    static function get($token, array $defaultConfig = [])
    {
        return new static($token, $defaultConfig);
    }

    public function __construct($token, array $defaultConfig)
    {
        $config = array_merge(
            [
                'headers' => $this->getHeaders($token),
                'base_uri' => Whereby::getBaseUri(self::VERSION),
            ],
            $defaultConfig
        );
        $this->client = new \GuzzleHttp\Client($config);
    }

    /**
     * @param $token
     * @return array
     */
    private function getHeaders($token): array
    {
        return ['Authorization' => "Bearer {$token}"];
    }

    public function meeting()
    {
        if (!$this->meeting instanceof Meeting) {
            $this->meeting = Meeting::getInstance($this->client);
        }

        return $this->meeting;
    }
}