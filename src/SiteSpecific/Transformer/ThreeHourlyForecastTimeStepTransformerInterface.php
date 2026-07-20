<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

interface ThreeHourlyForecastTimeStepTransformerInterface extends ForecastTimeStepTransformerInterface
{
    public const string KEY_FEELS_LIKE_TEMP = 'feelsLikeTemp';
    public const string KEY_MAX10M_WIND_GUST = 'max10mWindGust';
    public const string KEY_MAX_SCREEN_AIR_TEMP = 'maxScreenAirTemp';
    public const string KEY_MIN_SCREEN_AIR_TEMP = 'minScreenAirTemp';
    public const string KEY_MSLP = 'mslp';
    public const string KEY_PROB_OF_HAIL = 'probOfHail';
    public const string KEY_PROB_OF_HEAVY_RAIN = 'probOfHeavyRain';
    public const string KEY_PROB_OF_HEAVY_SNOW = 'probOfHeavySnow';
    public const string KEY_PROB_OF_PRECIPITATION = 'probOfPrecipitation';
    public const string KEY_PROB_OF_RAIN = 'probOfRain';
    public const string KEY_PROB_OF_SFERICS = 'probOfSferics';
    public const string KEY_PROB_OF_SNOW = 'probOfSnow';
    public const string KEY_SCREEN_RELATIVE_HUMIDITY = 'screenRelativeHumidity';
    public const string KEY_SIGNIFICANT_WEATHER_CODE = 'significantWeatherCode';
    public const string KEY_TIME = 'time';
    public const string KEY_TOTAL_PRECIP_AMOUNT = 'totalPrecipAmount';
    public const string KEY_TOTAL_SNOW_AMOUNT = 'totalSnowAmount';
    public const string KEY_UV_INDEX = 'uvIndex';
    public const string KEY_VISIBILITY = 'visibility';
    public const string KEY_WIND_DIRECTION_FROM10M = 'windDirectionFrom10m';
    public const string KEY_WIND_GUST_SPEED10M = 'windGustSpeed10m';
    public const string KEY_WIND_SPEED10M = 'windSpeed10m';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const string UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';
}
