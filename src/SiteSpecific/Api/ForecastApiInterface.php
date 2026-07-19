<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

interface ForecastApiInterface extends ApiInterface
{
    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getForecast(string $apiUrl, float $latitude, float $longitude, bool $skipCache = false): ForecastInterface;
}
