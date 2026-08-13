<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\ApiInterface as BaseApiInterface;

interface ApiInterface extends BaseApiInterface
{
    public const string API_URL_COLLECTION_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s';
    public const string API_URL_COLLECTIONS = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections';
    public const string API_URL_CONFORMANCE = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/conformance';
    public const string API_URL_INSTANCE_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s/instances/%s';
    public const string API_URL_INSTANCES_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s/instances';
    public const string API_URL_LANDING_PAGE = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0';
    public const string API_URL_LOCATION_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s/instances/%s/locations/%s';
    public const string API_URL_LOCATIONS_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s/instances/%s/locations';
    public const string API_URL_POSITION_SPRINTF = 'https://data.hub.api.metoffice.gov.uk/mo-blended-prob-forecast-feature-svc/2.0.0/collections/%s/instances/%s/position';
    public const string COORDS_POINT_SPRINTF = 'POINT(%s %s)';
    public const string HEADER_KEY_ACCEPT = 'Accept';
    public const string HEADER_VALUE_ACCEPT_JSON = 'application/json';
    public const string KEY_COLLECTIONS = 'collections';
    public const string KEY_CONFORMS_TO = 'conformsTo';
    public const string KEY_FEATURES = 'features';
    public const string KEY_INSTANCES = 'instances';
    public const string QUERY_KEY_COORDS = 'coords';
    public const string QUERY_KEY_DATETIME = 'datetime';
    public const string QUERY_KEY_PARAMETER_NAME = 'parameter-name';
    public const string QUERY_KEY_PERCENTILES = 'percentiles';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';
}
