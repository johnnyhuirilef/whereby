<?php

namespace Enius\Whereby\Provider\V1\Resource;

use Enius\Whereby\Provider\V1\Mapping;
use Enius\Whereby\Provider\V1\Util\TransformData;
use GuzzleHttp\Client;

class Meeting implements ResourceInterface
{
    private $client;

    /**
     * @param Client $client
     * @return Meeting
     */
    static function getInstance(Client $client)
    {
        return new static($client);
    }

    /**
     * User constructor.
     * @param Client $client
     */
    private function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $id
     * @return array|object
     * @throws \Enius\Whereby\Exception\ResponseStatusCodeError
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function get(int $meetingId)
    {
        $response = $this->client->get('meetings/' . $meetingId);
        $object = TransformData::handle($response, Mapping\Meeting\Get::class);

        return $object;
    }

    public function delete(int $meetingId)
    {
        $response = $this->client->delete('meetings/' . $meetingId);
        $object = TransformData::handle($response, Mapping\Meeting\Delete::class);

        return $object;
    }

    public function create(string $roomNamePrefix, string $startDate, string $endDate, string $roomMode = 'normal')
    {
        $roomNamePrefix = ltrim($roomNamePrefix, '/');
        $params = [
            'roomNamePrefix' => "/{$roomNamePrefix}",
            'roomMode' => $roomMode,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        $response = $this->client->post('meetings', [
            'json' => $params
        ]);
        $object = TransformData::handle($response, Mapping\Meeting\Create::class);

        return $object;
    }
}