<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Api;

use ChristianBrown\MetOffice\ApiInterface as BaseApiInterface;

interface ApiInterface extends BaseApiInterface
{
    public const string CACHE_KEY_SPRINTF = '%s,%s';
    public const string KEY_FEATURES = 'features';
    public const string KEY_PROPERTIES = 'properties';
    public const string QUERY_KEY_DATA_SOURCE = 'dataSource';
    public const string QUERY_KEY_EXCLUDE_PARAMETER_METADATA = 'excludeParameterMetadata';
    public const string QUERY_KEY_INCLUDE_LOCATION_NAME = 'includeLocationName';
    public const string QUERY_KEY_LATITUDE = 'latitude';
    public const string QUERY_KEY_LONGITUDE = 'longitude';
    public const string QUERY_VALUE_DATA_SOURCE = 'BD1';
    public const string QUERY_VALUE_TRUE = 'true';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';
}
