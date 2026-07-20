<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific;

use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;

interface SiteSpecificInterface
{
    public const string SERVICE_API_CLIENT = 'met_office.site_specific.api_client';
    public const string SERVICE_API_KEY = 'met_office.site_specific.api_key';
    public const string SERVICE_DAILY_FORECAST = 'met_office.site_specific.api.daily_forecast';
    public const string SERVICE_DAILY_FORECAST_API = 'met_office.site_specific.api.daily_forecast_api';
    public const string SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.site_specific.transformer.daily_forecast_time_step_transformer';
    public const string SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.site_specific.transformer.daily_forecast_time_steps_transformer';
    public const string SERVICE_DAILY_FORECAST_TRANSFORMER = 'met_office.site_specific.transformer.daily_forecast_transformer';
    public const string SERVICE_HOURLY_FORECAST = 'met_office.site_specific.api.hourly_forecast';
    public const string SERVICE_HOURLY_FORECAST_API = 'met_office.site_specific.api.hourly_forecast_api';
    public const string SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.site_specific.transformer.hourly_forecast_time_step_transformer';
    public const string SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.site_specific.transformer.hourly_forecast_time_steps_transformer';
    public const string SERVICE_HOURLY_FORECAST_TRANSFORMER = 'met_office.site_specific.transformer.hourly_forecast_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'met_office.site_specific.json_api_request_sender';
    public const string SERVICE_THREE_HOURLY_FORECAST = 'met_office.site_specific.api.three_hourly_forecast';
    public const string SERVICE_THREE_HOURLY_FORECAST_API = 'met_office.site_specific.api.three_hourly_forecast_api';
    public const string SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER = 'met_office.site_specific.transformer.three_hourly_forecast_time_step_transformer';
    public const string SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER = 'met_office.site_specific.transformer.three_hourly_forecast_time_steps_transformer';
    public const string SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER = 'met_office.site_specific.transformer.three_hourly_forecast_transformer';

    public function getDailyForecastApi(): DailyForecastApiInterface;

    public function getHourlyForecastApi(): HourlyForecastApiInterface;

    public function getThreeHourlyForecastApi(): ThreeHourlyForecastApiInterface;
}
