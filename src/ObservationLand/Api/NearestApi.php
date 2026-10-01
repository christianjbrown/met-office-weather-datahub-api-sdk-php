<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\CoordinatesInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformerInterface;

use function round;

final class NearestApi implements NearestApiInterface
{
    private ApiHostInterface $apiHost;
    private ApiKeyInterface $apiKey;
    private NearestLocationsTransformerInterface $nearestLocationsTransformer;
    private JsonReadApiRequestSenderInterface $requestSender;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, NearestLocationsTransformerInterface $nearestLocationsTransformer, ApiKeyInterface $apiKey, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->nearestLocationsTransformer = $nearestLocationsTransformer;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, NearestLocationInterface>
     */
    public function getByCoordinates(CoordinatesInterface $coordinates, ?int $max = null): array
    {
        $headers = $this->apiKey->toHeaders();
        $query = self::withMax(
            [
                self::QUERY_KEY_LAT => self::formatCoordinate($coordinates->getLatitude()),
                self::QUERY_KEY_LON => self::formatCoordinate($coordinates->getLongitude()),
            ],
            $max
        );
        $data = $this->requestSender->get($this->apiHost->rewrite(self::API_URL_NEAREST), $query, $headers);

        return $this->nearestLocationsTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, NearestLocationInterface>
     */
    public function getByGeohash(string $geohash, ?int $max = null): array
    {
        $headers = $this->apiKey->toHeaders();
        $query = self::withMax(
            [
                self::QUERY_KEY_GEOHASH => $geohash,
            ],
            $max
        );
        $data = $this->requestSender->get($this->apiHost->rewrite(self::API_URL_NEAREST), $query, $headers);

        return $this->nearestLocationsTransformer->transform($data);
    }

    private static function formatCoordinate(float $value): string
    {
        return (string) round($value, 2);
    }

    /**
     * @param array<string, string> $query
     *
     * @return array<string, string>
     */
    private static function withMax(array $query, ?int $max): array
    {
        if (null === $max) {
            return $query;
        }
        $query[self::QUERY_KEY_MAX] = (string) $max;

        return $query;
    }
}
