<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Model\ForecastInterface;
use ChristianBrown\MetOffice\Transformer\ForecastTransformerInterface;

use function array_values;
use function is_array;
use function sprintf;

final class HourlyForecastApi implements HourlyForecastApiInterface
{
    private string $apiKey;

    /**
     * @var array<string, ForecastInterface>
     */
    private array $cache = [];
    private ForecastTransformerInterface $forecastTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ForecastTransformerInterface $forecastTransformer, string $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->forecastTransformer = $forecastTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getForecast(float $latitude, float $longitude, bool $skipCache = false): ForecastInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $latitude, $longitude);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_API_KEY => $this->apiKey,
        ];
        $query = [
            self::QUERY_KEY_LATITUDE => (string) $latitude,
            self::QUERY_KEY_LONGITUDE => (string) $longitude,
            self::QUERY_KEY_DATA_SOURCE => self::QUERY_VALUE_DATA_SOURCE,
            self::QUERY_KEY_EXCLUDE_PARAMETER_METADATA => self::QUERY_VALUE_TRUE,
            self::QUERY_KEY_INCLUDE_LOCATION_NAME => self::QUERY_VALUE_TRUE,
        ];
        $data = $this->requestSender->get(self::API_URL, $query, $headers);

        $forecast = $this->forecastTransformer->transform($this->extractProperties($data));
        $this->cache[$cacheKey] = $forecast;

        return $forecast;
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function extractProperties(array $data): array
    {
        if (empty($data[self::KEY_FEATURES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }
        if (!is_array($data[self::KEY_FEATURES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }
        $features = array_values($data[self::KEY_FEATURES]);
        if (empty($features[0])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }
        if (!is_array($features[0])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FEATURES));
        }
        $feature = $features[0];
        if (empty($feature[self::KEY_PROPERTIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_PROPERTIES));
        }
        if (!is_array($feature[self::KEY_PROPERTIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_PROPERTIES));
        }

        return $feature[self::KEY_PROPERTIES];
    }
}
