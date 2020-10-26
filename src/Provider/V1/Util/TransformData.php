<?php


namespace Enius\Whereby\Provider\V1\Util;

use Enius\Whereby\Whereby;
use Psr\Http\Message\ResponseInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TransformData
{
    /**
     * @param ResponseInterface $response
     * @param string $class
     * @return array|object
     * @throws \Enius\Whereby\Exception\ResponseStatusCodeError
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    static function handle(ResponseInterface $response, string $class)
    {
        Whereby::checkResponseStatusCodeError($response);
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $contents = $response->getBody()->getContents();
        if (empty($contents)) {
            $contents = json_encode([]);
        }
        return $serializer->denormalize(\GuzzleHttp\json_decode($contents), $class, 'json');
    }
}