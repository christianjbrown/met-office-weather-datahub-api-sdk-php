<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Api;

use ChristianBrown\MetOffice\Model\ForecastInterface;

interface ThreeHourlyForecastApiInterface extends ApiInterface
{
    public const API_URL = 'https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/three-hourly';

    public function getForecast(float $latitude, float $longitude, bool $skipCache = false): ForecastInterface;
}
