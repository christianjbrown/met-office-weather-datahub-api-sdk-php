<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\MetOffice\ApiInterface as BaseApiInterface;

interface ApiInterface extends BaseApiInterface
{
    public const string API_URL_COLLECTION_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0/collections/%s';
    public const string API_URL_COLLECTIONS = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0/collections';
    public const string API_URL_CONFORMANCE = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0/conformance';
    public const string API_URL_COVERAGE_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0/collections/%s/locations/%s';
    public const string API_URL_LANDING_PAGE = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0';
    public const string API_URL_LOCATIONS_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-site-specific-blended-probabilistic-forecast/1.0.0/collections/%s/locations';
    public const string HEADER_KEY_ACCEPT = 'Accept';
    public const string HEADER_VALUE_ACCEPT_JSON = 'application/json';
    public const string KEY_COLLECTIONS = 'collections';
    public const string KEY_CONFORMS_TO = 'conformsTo';
    public const string KEY_FEATURES = 'features';
    public const string QUERY_KEY_DATETIME = 'datetime';
    public const string QUERY_KEY_PARAMETER_NAME = 'parameter-name';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';
}
