<?php


namespace Enius\Whereby\Provider\V1\Resource;

use GuzzleHttp\Client;

interface ResourceInterface
{
    static function getInstance(Client $client);
}