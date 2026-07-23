<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended;

use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApiInterface;

interface SiteSpecificBlendedInterface
{
    public const string SERVICE_API_CLIENT = 'met_office.site_specific_blended.api_client';
    public const string SERVICE_API_KEY = 'met_office.site_specific_blended.api_key';
    public const string SERVICE_AXES_TRANSFORMER = 'met_office.site_specific_blended.transformer.axes_transformer';
    public const string SERVICE_AXIS_TRANSFORMER = 'met_office.site_specific_blended.transformer.axis_transformer';
    public const string SERVICE_CAPABILITIES_API = 'met_office.site_specific_blended.api.capabilities_api';
    public const string SERVICE_COLLECTION_TRANSFORMER = 'met_office.site_specific_blended.transformer.collection_transformer';
    public const string SERVICE_COLLECTIONS_API = 'met_office.site_specific_blended.api.collections_api';
    public const string SERVICE_COLLECTIONS_TRANSFORMER = 'met_office.site_specific_blended.transformer.collections_transformer';
    public const string SERVICE_CONFORMANCE_TRANSFORMER = 'met_office.site_specific_blended.transformer.conformance_transformer';
    public const string SERVICE_COVERAGE_COLLECTION_TRANSFORMER = 'met_office.site_specific_blended.transformer.coverage_collection_transformer';
    public const string SERVICE_COVERAGE_TRANSFORMER = 'met_office.site_specific_blended.transformer.coverage_transformer';
    public const string SERVICE_COVERAGES_TRANSFORMER = 'met_office.site_specific_blended.transformer.coverages_transformer';
    public const string SERVICE_DOMAIN_TRANSFORMER = 'met_office.site_specific_blended.transformer.domain_transformer';
    public const string SERVICE_EXTENT_TRANSFORMER = 'met_office.site_specific_blended.transformer.extent_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'met_office.site_specific_blended.json_api_request_sender';
    public const string SERVICE_LANDING_PAGE_TRANSFORMER = 'met_office.site_specific_blended.transformer.landing_page_transformer';
    public const string SERVICE_LINK_TRANSFORMER = 'met_office.site_specific_blended.transformer.link_transformer';
    public const string SERVICE_LINKS_TRANSFORMER = 'met_office.site_specific_blended.transformer.links_transformer';
    public const string SERVICE_LOCATION_TRANSFORMER = 'met_office.site_specific_blended.transformer.location_transformer';
    public const string SERVICE_LOCATIONS_API = 'met_office.site_specific_blended.api.locations_api';
    public const string SERVICE_LOCATIONS_TRANSFORMER = 'met_office.site_specific_blended.transformer.locations_transformer';
    public const string SERVICE_PARAMETER_TRANSFORMER = 'met_office.site_specific_blended.transformer.parameter_transformer';
    public const string SERVICE_PARAMETERS_TRANSFORMER = 'met_office.site_specific_blended.transformer.parameters_transformer';
    public const string SERVICE_RANGE_TRANSFORMER = 'met_office.site_specific_blended.transformer.range_transformer';
    public const string SERVICE_RANGES_TRANSFORMER = 'met_office.site_specific_blended.transformer.ranges_transformer';

    public function getCapabilitiesApi(): CapabilitiesApiInterface;

    public function getCollectionsApi(): CollectionsApiInterface;

    public function getLocationsApi(): LocationsApiInterface;
}
