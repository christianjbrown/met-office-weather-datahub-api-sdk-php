<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApiInterface;

interface AtmosphericModelsInterface
{
    public const SERVICE_API_CLIENT = 'met_office.atmospheric_models.api_client';
    public const SERVICE_API_KEY = 'met_office.atmospheric_models.api_key';
    public const SERVICE_API_REQUEST_SENDER = 'met_office.atmospheric_models.api_request_sender';
    public const SERVICE_AXIS_EXTENT_TRANSFORMER = 'met_office.atmospheric_models.transformer.axis_extent_transformer';
    public const SERVICE_JSON_API_REQUEST_SENDER = 'met_office.atmospheric_models.json_api_request_sender';
    public const SERVICE_ORDER_FILE_DETAILS_TRANSFORMER = 'met_office.atmospheric_models.transformer.order_file_details_transformer';
    public const SERVICE_ORDER_FILE_TRANSFORMER = 'met_office.atmospheric_models.transformer.order_file_transformer';
    public const SERVICE_ORDER_FILES_TRANSFORMER = 'met_office.atmospheric_models.transformer.order_files_transformer';
    public const SERVICE_ORDER_TRANSFORMER = 'met_office.atmospheric_models.transformer.order_transformer';
    public const SERVICE_ORDERS_API = 'met_office.atmospheric_models.api.orders_api';
    public const SERVICE_ORDERS_TRANSFORMER = 'met_office.atmospheric_models.transformer.orders_transformer';
    public const SERVICE_PARAMETER_DETAIL_TRANSFORMER = 'met_office.atmospheric_models.transformer.parameter_detail_transformer';
    public const SERVICE_PARAMETER_DETAILS_TRANSFORMER = 'met_office.atmospheric_models.transformer.parameter_details_transformer';
    public const SERVICE_REGION_TRANSFORMER = 'met_office.atmospheric_models.transformer.region_transformer';
    public const SERVICE_REGIONS_TRANSFORMER = 'met_office.atmospheric_models.transformer.regions_transformer';
    public const SERVICE_RUN_DETAIL_TRANSFORMER = 'met_office.atmospheric_models.transformer.run_detail_transformer';
    public const SERVICE_RUN_DETAILS_TRANSFORMER = 'met_office.atmospheric_models.transformer.run_details_transformer';
    public const SERVICE_RUN_TRANSFORMER = 'met_office.atmospheric_models.transformer.run_transformer';
    public const SERVICE_RUNS_API = 'met_office.atmospheric_models.api.runs_api';
    public const SERVICE_RUNS_TRANSFORMER = 'met_office.atmospheric_models.transformer.runs_transformer';

    public function getOrdersApi(): OrdersApiInterface;

    public function getRunsApi(): RunsApiInterface;
}
