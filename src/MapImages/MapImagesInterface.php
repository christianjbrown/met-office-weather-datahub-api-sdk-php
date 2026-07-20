<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages;

use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;

interface MapImagesInterface
{
    public const SERVICE_API_CLIENT = 'met_office.map_images.api_client';
    public const SERVICE_API_KEY = 'met_office.map_images.api_key';
    public const SERVICE_API_REQUEST_SENDER = 'met_office.map_images.api_request_sender';
    public const SERVICE_AXIS_EXTENT_TRANSFORMER = 'met_office.map_images.transformer.axis_extent_transformer';
    public const SERVICE_JSON_API_REQUEST_SENDER = 'met_office.map_images.json_api_request_sender';
    public const SERVICE_ORDER_FILE_DETAILS_TRANSFORMER = 'met_office.map_images.transformer.order_file_details_transformer';
    public const SERVICE_ORDER_FILE_TRANSFORMER = 'met_office.map_images.transformer.order_file_transformer';
    public const SERVICE_ORDER_FILES_TRANSFORMER = 'met_office.map_images.transformer.order_files_transformer';
    public const SERVICE_ORDER_TRANSFORMER = 'met_office.map_images.transformer.order_transformer';
    public const SERVICE_ORDERS_API = 'met_office.map_images.api.orders_api';
    public const SERVICE_ORDERS_TRANSFORMER = 'met_office.map_images.transformer.orders_transformer';
    public const SERVICE_PARAMETER_DETAIL_TRANSFORMER = 'met_office.map_images.transformer.parameter_detail_transformer';
    public const SERVICE_PARAMETER_DETAILS_TRANSFORMER = 'met_office.map_images.transformer.parameter_details_transformer';
    public const SERVICE_REGION_TRANSFORMER = 'met_office.map_images.transformer.region_transformer';
    public const SERVICE_REGIONS_TRANSFORMER = 'met_office.map_images.transformer.regions_transformer';
    public const SERVICE_RUN_DETAIL_TRANSFORMER = 'met_office.map_images.transformer.run_detail_transformer';
    public const SERVICE_RUN_DETAILS_TRANSFORMER = 'met_office.map_images.transformer.run_details_transformer';
    public const SERVICE_RUN_TRANSFORMER = 'met_office.map_images.transformer.run_transformer';
    public const SERVICE_RUNS_API = 'met_office.map_images.api.runs_api';
    public const SERVICE_RUNS_TRANSFORMER = 'met_office.map_images.transformer.runs_transformer';

    public function getOrdersApi(): OrdersApiInterface;

    public function getRunsApi(): RunsApiInterface;
}
