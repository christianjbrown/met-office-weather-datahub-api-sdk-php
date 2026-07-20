<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Api;

use ChristianBrown\MetOffice\CoordinatesInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

interface DailyForecastApiInterface extends ApiInterface
{
    public const API_URL = 'https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/daily';

    public function getForecast(CoordinatesInterface $coordinates, bool $skipCache = false): ForecastInterface;
}
