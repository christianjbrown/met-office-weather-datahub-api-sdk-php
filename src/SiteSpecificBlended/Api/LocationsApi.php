<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformerInterface;

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
    public function getCoverage(string $collectionId, string $locationId, ?string $parameterName = null, ?string $datetime = null): CoverageCollectionInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_COVERAGE_SPRINTF, $collectionId, rawurlencode($locationId)), self::buildCoverageQuery($parameterName, $datetime), $headers);

        return $this->coverageCollectionTransformer->transform($data);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, LocationInterface>
     */
    public function getLocations(string $collectionId): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_LOCATIONS_SPRINTF, $collectionId), [], $headers);

        return $this->locationsTransformer->transform(self::extractFeatures($data));
    }

    /**
     * @return array<string, string>
     */
    private static function buildCoverageQuery(?string $parameterName, ?string $datetime): array
    {
        $query = [];
        if (null !== $parameterName) {
            $query[self::QUERY_KEY_PARAMETER_NAME] = $parameterName;
        }
        if (null !== $datetime) {
            $query[self::QUERY_KEY_DATETIME] = $datetime;
        }

        return $query;
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
