<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LocationInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationsApi implements LocationsApiInterface
{
    private ApiKeyInterface $apiKey;
    private CoverageCollectionTransformerInterface $coverageCollectionTransformer;
    private LocationsTransformerInterface $locationsTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, LocationsTransformerInterface $locationsTransformer, CoverageCollectionTransformerInterface $coverageCollectionTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->locationsTransformer = $locationsTransformer;
        $this->coverageCollectionTransformer = $coverageCollectionTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getLocation(string $collectionId, string $instanceId, string $locationId, ?DataQueryInterface $query = null): CoverageCollectionInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_LOCATION_SPRINTF, $collectionId, rawurlencode($instanceId), rawurlencode($locationId)), self::buildQuery($query), $headers);

        return $this->coverageCollectionTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocationInterface>
     */
    public function getLocations(string $collectionId, string $instanceId): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_LOCATIONS_SPRINTF, $collectionId, rawurlencode($instanceId)), [], $headers);

        return $this->locationsTransformer->transform(self::extractFeatures($data));
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?DataQueryInterface $query): array
    {
        if (null === $query) {
            return [];
        }

        return $query->toQuery();
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractFeatures(array $data): array
    {
        if (!isset($data[self::KEY_FEATURES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }
        if (!is_array($data[self::KEY_FEATURES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }

        return $data[self::KEY_FEATURES];
    }
}
