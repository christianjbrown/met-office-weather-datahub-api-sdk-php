<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

interface DailyForecastTimeStepTransformerInterface extends ForecastTimeStepTransformerInterface
{
    public const KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP = 'dayLowerBoundMaxFeelsLikeTemp';
    public const KEY_DAY_LOWER_BOUND_MAX_TEMP = 'dayLowerBoundMaxTemp';
    public const KEY_DAY_MAX_FEELS_LIKE_TEMP = 'dayMaxFeelsLikeTemp';
    public const KEY_DAY_MAX_SCREEN_TEMPERATURE = 'dayMaxScreenTemperature';
    public const KEY_DAY_PROBABILITY_OF_HAIL = 'dayProbabilityOfHail';
    public const KEY_DAY_PROBABILITY_OF_HEAVY_RAIN = 'dayProbabilityOfHeavyRain';
    public const KEY_DAY_PROBABILITY_OF_HEAVY_SNOW = 'dayProbabilityOfHeavySnow';
    public const KEY_DAY_PROBABILITY_OF_PRECIPITATION = 'dayProbabilityOfPrecipitation';
    public const KEY_DAY_PROBABILITY_OF_RAIN = 'dayProbabilityOfRain';
    public const KEY_DAY_PROBABILITY_OF_SFERICS = 'dayProbabilityOfSferics';
    public const KEY_DAY_PROBABILITY_OF_SNOW = 'dayProbabilityOfSnow';
    public const KEY_DAY_SIGNIFICANT_WEATHER_CODE = 'daySignificantWeatherCode';
    public const KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP = 'dayUpperBoundMaxFeelsLikeTemp';
    public const KEY_DAY_UPPER_BOUND_MAX_TEMP = 'dayUpperBoundMaxTemp';
    public const KEY_MAX_UV_INDEX = 'maxUvIndex';
    public const KEY_MIDDAY10_M_WIND_DIRECTION = 'midday10MWindDirection';
    public const KEY_MIDDAY10_M_WIND_GUST = 'midday10MWindGust';
    public const KEY_MIDDAY10_M_WIND_SPEED = 'midday10MWindSpeed';
    public const KEY_MIDDAY_MSLP = 'middayMslp';
    public const KEY_MIDDAY_RELATIVE_HUMIDITY = 'middayRelativeHumidity';
    public const KEY_MIDDAY_VISIBILITY = 'middayVisibility';
    public const KEY_MIDNIGHT10_M_WIND_DIRECTION = 'midnight10MWindDirection';
    public const KEY_MIDNIGHT10_M_WIND_GUST = 'midnight10MWindGust';
    public const KEY_MIDNIGHT10_M_WIND_SPEED = 'midnight10MWindSpeed';
    public const KEY_MIDNIGHT_MSLP = 'midnightMslp';
    public const KEY_MIDNIGHT_RELATIVE_HUMIDITY = 'midnightRelativeHumidity';
    public const KEY_MIDNIGHT_VISIBILITY = 'midnightVisibility';
    public const KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP = 'nightLowerBoundMinFeelsLikeTemp';
    public const KEY_NIGHT_LOWER_BOUND_MIN_TEMP = 'nightLowerBoundMinTemp';
    public const KEY_NIGHT_MIN_FEELS_LIKE_TEMP = 'nightMinFeelsLikeTemp';
    public const KEY_NIGHT_MIN_SCREEN_TEMPERATURE = 'nightMinScreenTemperature';
    public const KEY_NIGHT_PROBABILITY_OF_HAIL = 'nightProbabilityOfHail';
    public const KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN = 'nightProbabilityOfHeavyRain';
    public const KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW = 'nightProbabilityOfHeavySnow';
    public const KEY_NIGHT_PROBABILITY_OF_PRECIPITATION = 'nightProbabilityOfPrecipitation';
    public const KEY_NIGHT_PROBABILITY_OF_RAIN = 'nightProbabilityOfRain';
    public const KEY_NIGHT_PROBABILITY_OF_SFERICS = 'nightProbabilityOfSferics';
    public const KEY_NIGHT_PROBABILITY_OF_SNOW = 'nightProbabilityOfSnow';
    public const KEY_NIGHT_SIGNIFICANT_WEATHER_CODE = 'nightSignificantWeatherCode';
    public const KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP = 'nightUpperBoundMinFeelsLikeTemp';
    public const KEY_NIGHT_UPPER_BOUND_MIN_TEMP = 'nightUpperBoundMinTemp';
    public const KEY_TIME = 'time';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';
}
