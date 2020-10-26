<?php

namespace Enius\Whereby\Provider\V1\Resource;

use Enius\Whereby\Provider\V1\Mapping;
use Enius\Whereby\Provider\V1\Util\TransformData;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

class Meeting implements ResourceInterface
{
    private $client;
    const ROOM_MODE_NORMAL = 'normal';
    const ROOM_MODE_GROUP = 'group';

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
    public function get(int $meetingId, array $fields = [])
    {
        $response = $this->client->get(
            'meetings/'.$meetingId,
            [
                'query' => ['fields' => implode(',', $fields)]
            ]
        );
        $object = TransformData::handle($response, Mapping\Meeting\Get::class);

        return $object;
    }

    public function delete(int $meetingId)
    {
        $response = $this->client->delete('meetings/'.$meetingId);
        $object = TransformData::handle($response, Mapping\Meeting\Delete::class);

        return $object;
    }

    /**
     *
     * params['isLocked'] boolean The initial lock state of the room. If true, only hosts will be able to let in other participants and change lock state.
     * params['roomNamePrefix'] string <= 40 characters [/][a-z0-9]{0,39} This will be used as the prefix for the room name. Note that the room name needs to start with / if it is provided and should be lower-case.
     * params['roomMode'] string Default normal enum("group" "normal") The mode of the created transient room. is the default room mode and should be used for meetings up to 4 participants. should be used for meetings that require more than 4 participants.normal group
     * params['fields'] array Additional fields that should be populated.
     * params['fields']['hostRoomUrl'] Include hostRoomUrl field in the meeting response.
     *
     * $params = [
     *  "isLocked" => true,
     *  "roomNamePrefix" => "/example-prefix",
     *  "roomMode" => "normal",
     *  "fields" => ["hostRoomUrl"]
     * ]
     *
     * @param $startDate string
     * @param $endDate string
     * @param array $params
     * @return array|object
     * @throws \Enius\Whereby\Exception\ResponseStatusCodeError
     */
    public function create($startDate, $endDate, array $params)
    {
        if (array_key_exists('roomNamePrefix', $params)) {
            $params['roomNamePrefix'] = ltrim($params['roomNamePrefix'], '/');;
        }
        if (array_key_exists('roomMode', $params) && !in_array($params['roomMode'], [self::ROOM_MODE_NORMAL, self::ROOM_MODE_GROUP])) {
            $params['roomMode'] = self::ROOM_MODE_NORMAL;
        }

        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
        $response = $this->client->post(
            'meetings',
            [
                'json' => $params,
            ]
        );
        $object = TransformData::handle($response, Mapping\Meeting\Create::class);

        return $object;
    }
}