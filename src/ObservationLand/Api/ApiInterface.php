<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\MetOffice\ApiInterface as BaseApiInterface;

interface ApiInterface extends BaseApiInterface
{
    public const string API_URL_NEAREST = 'https://data.hub.api.metoffice.gov.uk/observation-land/1/nearest';
    public const string API_URL_OBSERVATION_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/observation-land/1/%s';
    public const string QUERY_KEY_GEOHASH = 'geohash';
    public const string QUERY_KEY_LAT = 'lat';
    public const string QUERY_KEY_LON = 'lon';
}
