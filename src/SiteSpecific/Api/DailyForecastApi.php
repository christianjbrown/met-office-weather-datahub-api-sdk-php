<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

final class DailyForecastApi implements DailyForecastApiInterface
{
    private ForecastApiInterface $forecastApi;

    public function __construct(ForecastApiInterface $forecastApi)
    {
        $this->forecastApi = $forecastApi;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getForecast(float $latitude, float $longitude, bool $skipCache = false): ForecastInterface
    {
        return $this->forecastApi->getForecast(self::API_URL, $latitude, $longitude, $skipCache);
    }
}
