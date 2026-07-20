<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand;

use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;

interface ObservationLandInterface
{
    public const SERVICE_API_CLIENT = 'met_office.observation_land.api_client';
    public const SERVICE_API_KEY = 'met_office.observation_land.api_key';
    public const SERVICE_JSON_API_REQUEST_SENDER = 'met_office.observation_land.json_api_request_sender';
    public const SERVICE_NEAREST_API = 'met_office.observation_land.api.nearest_api';
    public const SERVICE_NEAREST_LOCATION_TRANSFORMER = 'met_office.observation_land.transformer.nearest_location_transformer';
    public const SERVICE_NEAREST_LOCATIONS_TRANSFORMER = 'met_office.observation_land.transformer.nearest_locations_transformer';
    public const SERVICE_OBSERVATION_API = 'met_office.observation_land.api.observation_api';
    public const SERVICE_OBSERVATION_TRANSFORMER = 'met_office.observation_land.transformer.observation_transformer';
    public const SERVICE_OBSERVATIONS_TRANSFORMER = 'met_office.observation_land.transformer.observations_transformer';

    public function getNearestApi(): NearestApiInterface;

    public function getObservationApi(): ObservationApiInterface;
}
