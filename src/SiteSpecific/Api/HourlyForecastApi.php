<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\MetOffice\CoordinatesInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

final class HourlyForecastApi implements HourlyForecastApiInterface
{
    private ApiHostInterface $apiHost;
    private ForecastApiInterface $forecastApi;

    public function __construct(ForecastApiInterface $forecastApi, ApiHostInterface $apiHost)
    {
        $this->forecastApi = $forecastApi;
        $this->apiHost = $apiHost;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getForecast(CoordinatesInterface $coordinates, bool $skipCache = false, bool $includeParameterMetadata = false): ForecastInterface
    {
        return $this->forecastApi->getForecast($this->apiHost->rewrite(self::API_URL), $coordinates, $skipCache, $includeParameterMetadata);
    }
}
