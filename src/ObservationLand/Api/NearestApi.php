<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformerInterface;

use function round;

final class NearestApi implements NearestApiInterface
{
    private ApiKeyInterface $apiKey;
    private NearestLocationsTransformerInterface $nearestLocationsTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, NearestLocationsTransformerInterface $nearestLocationsTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->nearestLocationsTransformer = $nearestLocationsTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, NearestLocationInterface>
     */
    public function getByCoordinates(float $latitude, float $longitude): array
    {
        $headers = $this->apiKey->toHeaders();
        $query = [
            self::QUERY_KEY_LAT => $this->formatCoordinate($latitude),
            self::QUERY_KEY_LON => $this->formatCoordinate($longitude),
        ];
        $data = $this->requestSender->get(self::API_URL_NEAREST, $query, $headers);

        return $this->nearestLocationsTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, NearestLocationInterface>
     */
    public function getByGeohash(string $geohash): array
    {
        $headers = $this->apiKey->toHeaders();
        $query = [
            self::QUERY_KEY_GEOHASH => $geohash,
        ];
        $data = $this->requestSender->get(self::API_URL_NEAREST, $query, $headers);

        return $this->nearestLocationsTransformer->transform($data);
    }

    private function formatCoordinate(float $value): string
    {
        return (string) round($value, 2);
    }
}
