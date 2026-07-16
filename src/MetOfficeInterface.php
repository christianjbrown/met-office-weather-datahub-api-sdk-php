<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\Api\ThreeHourlyForecastApiInterface;

interface MetOfficeInterface
{
    public const SERVICE_API_CLIENT = 'met_office.api_client';
    public const SERVICE_DAILY_FORECAST_API = 'met_office.api.daily_forecast_api';
    public const SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.transformer.daily_forecast_time_step_transformer';
    public const SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.transformer.daily_forecast_time_steps_transformer';
    public const SERVICE_DAILY_FORECAST_TRANSFORMER = 'met_office.transformer.daily_forecast_transformer';
    public const SERVICE_HOURLY_FORECAST_API = 'met_office.api.hourly_forecast_api';
    public const SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.transformer.hourly_forecast_time_step_transformer';
    public const SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.transformer.hourly_forecast_time_steps_transformer';
    public const SERVICE_HOURLY_FORECAST_TRANSFORMER = 'met_office.transformer.hourly_forecast_transformer';
    public const SERVICE_JSON_API_REQUEST_SENDER = 'met_office.json_api_request_sender';
    public const SERVICE_THREE_HOURLY_FORECAST_API = 'met_office.api.three_hourly_forecast_api';
    public const SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.transformer.three_hourly_forecast_time_step_transformer';
    public const SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.transformer.three_hourly_forecast_time_steps_transformer';
    public const SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER = 'met_office.transformer.three_hourly_forecast_transformer';

    public function getDailyForecastApi(): DailyForecastApiInterface;

    public function getHourlyForecastApi(): HourlyForecastApiInterface;

    public function getThreeHourlyForecastApi(): ThreeHourlyForecastApiInterface;
}
