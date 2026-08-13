<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;

interface BlendedProbForecastInterface
{
    public const string SERVICE_API_CLIENT = 'met_office.blended_prob_forecast.api_client';
    public const string SERVICE_API_KEY = 'met_office.blended_prob_forecast.api_key';
    public const string SERVICE_AXES_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.axes_transformer';
    public const string SERVICE_AXIS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.axis_transformer';
    public const string SERVICE_CAPABILITIES_API = 'met_office.blended_prob_forecast.api.capabilities_api';
    public const string SERVICE_COLLECTION_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.collection_transformer';
    public const string SERVICE_COLLECTIONS_API = 'met_office.blended_prob_forecast.api.collections_api';
    public const string SERVICE_COLLECTIONS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.collections_transformer';
    public const string SERVICE_CONFORMANCE_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.conformance_transformer';
    public const string SERVICE_COVERAGE_COLLECTION_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.coverage_collection_transformer';
    public const string SERVICE_COVERAGE_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.coverage_transformer';
    public const string SERVICE_COVERAGES_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.coverages_transformer';
    public const string SERVICE_DOMAIN_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.domain_transformer';
    public const string SERVICE_EXTENT_CUSTOM_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.extent_custom_transformer';
    public const string SERVICE_EXTENT_CUSTOMS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.extent_customs_transformer';
    public const string SERVICE_EXTENT_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.extent_transformer';
    public const string SERVICE_INSTANCE_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.instance_transformer';
    public const string SERVICE_INSTANCES_API = 'met_office.blended_prob_forecast.api.instances_api';
    public const string SERVICE_INSTANCES_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.instances_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'met_office.blended_prob_forecast.json_api_request_sender';
    public const string SERVICE_LANDING_PAGE_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.landing_page_transformer';
    public const string SERVICE_LINK_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.link_transformer';
    public const string SERVICE_LINKS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.links_transformer';
    public const string SERVICE_LOCATION_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.location_transformer';
    public const string SERVICE_LOCATIONS_API = 'met_office.blended_prob_forecast.api.locations_api';
    public const string SERVICE_LOCATIONS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.locations_transformer';
    public const string SERVICE_PARAMETER_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.parameter_transformer';
    public const string SERVICE_PARAMETERS_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.parameters_transformer';
    public const string SERVICE_POSITION_API = 'met_office.blended_prob_forecast.api.position_api';
    public const string SERVICE_RANGE_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.range_transformer';
    public const string SERVICE_RANGES_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.ranges_transformer';
    public const string SERVICE_REFERENCE_SYSTEM_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.reference_system_transformer';
    public const string SERVICE_REFERENCING_TRANSFORMER = 'met_office.blended_prob_forecast.transformer.referencing_transformer';

    public function getCapabilitiesApi(): CapabilitiesApiInterface;

    public function getCollectionsApi(): CollectionsApiInterface;

    public function getInstancesApi(): InstancesApiInterface;

    public function getLocationsApi(): LocationsApiInterface;

    public function getPositionApi(): PositionApiInterface;
}
