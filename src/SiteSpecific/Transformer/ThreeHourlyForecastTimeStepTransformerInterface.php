<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

interface ThreeHourlyForecastTimeStepTransformerInterface extends ForecastTimeStepTransformerInterface
{
    public const KEY_FEELS_LIKE_TEMP = 'feelsLikeTemp';
    public const KEY_MAX10M_WIND_GUST = 'max10mWindGust';
    public const KEY_MAX_SCREEN_AIR_TEMP = 'maxScreenAirTemp';
    public const KEY_MIN_SCREEN_AIR_TEMP = 'minScreenAirTemp';
    public const KEY_MSLP = 'mslp';
    public const KEY_PROB_OF_HAIL = 'probOfHail';
    public const KEY_PROB_OF_HEAVY_RAIN = 'probOfHeavyRain';
    public const KEY_PROB_OF_HEAVY_SNOW = 'probOfHeavySnow';
    public const KEY_PROB_OF_PRECIPITATION = 'probOfPrecipitation';
    public const KEY_PROB_OF_RAIN = 'probOfRain';
    public const KEY_PROB_OF_SFERICS = 'probOfSferics';
    public const KEY_PROB_OF_SNOW = 'probOfSnow';
    public const KEY_SCREEN_RELATIVE_HUMIDITY = 'screenRelativeHumidity';
    public const KEY_SIGNIFICANT_WEATHER_CODE = 'significantWeatherCode';
    public const KEY_TIME = 'time';
    public const KEY_TOTAL_PRECIP_AMOUNT = 'totalPrecipAmount';
    public const KEY_TOTAL_SNOW_AMOUNT = 'totalSnowAmount';
    public const KEY_UV_INDEX = 'uvIndex';
    public const KEY_VISIBILITY = 'visibility';
    public const KEY_WIND_DIRECTION_FROM10M = 'windDirectionFrom10m';
    public const KEY_WIND_GUST_SPEED10M = 'windGustSpeed10m';
    public const KEY_WIND_SPEED10M = 'windSpeed10m';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';
}
