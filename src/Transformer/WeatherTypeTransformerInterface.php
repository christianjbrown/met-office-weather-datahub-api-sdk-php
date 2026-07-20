<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;

interface WeatherTypeTransformerInterface
{
    public const array WEATHER_TYPE_EMOJIS = [
        WeatherType::CLEAR_NIGHT->value => '🌙',
        WeatherType::CLOUDY->value => '☁️',
        WeatherType::DRIZZLE->value => '🌧️',
        WeatherType::FOG->value => '🌫️',
        WeatherType::HAIL->value => '🌨',
        WeatherType::HAIL_SHOWER_DAY->value => '🌨',
        WeatherType::HAIL_SHOWER_NIGHT->value => '🌨',
        WeatherType::HEAVY_RAIN->value => '🌧',
        WeatherType::HEAVY_RAIN_SHOWER_DAY->value => '🌧',
        WeatherType::HEAVY_RAIN_SHOWER_NIGHT->value => '🌧',
        WeatherType::HEAVY_SNOW->value => '🌨',
        WeatherType::HEAVY_SNOW_SHOWER_DAY->value => '🌨',
        WeatherType::HEAVY_SNOW_SHOWER_NIGHT->value => '🌨',
        WeatherType::LIGHT_RAIN->value => '🌦',
        WeatherType::LIGHT_RAIN_SHOWER_DAY->value => '🌦',
        WeatherType::LIGHT_RAIN_SHOWER_NIGHT->value => '🌧',
        WeatherType::LIGHT_SNOW->value => '🌨',
        WeatherType::LIGHT_SNOW_SHOWER_DAY->value => '🌨️',
        WeatherType::LIGHT_SNOW_SHOWER_NIGHT->value => '🌨️',
        WeatherType::MIST->value => '🌫️',
        WeatherType::OVERCAST->value => '🌥',
        WeatherType::PARTLY_CLOUDY_DAY->value => '☁️',
        WeatherType::PARTLY_CLOUDY_NIGHT->value => '☁️',
        WeatherType::SLEET->value => '🌨',
        WeatherType::SLEET_SHOWER_DAY->value => '🌨️',
        WeatherType::SLEET_SHOWER_NIGHT->value => '🌨️',
        WeatherType::SUNNY_DAY->value => '☀️',
        WeatherType::THUNDER->value => '🌩',
        WeatherType::THUNDER_SHOWER_DAY->value => '⛈️',
        WeatherType::THUNDER_SHOWER_NIGHT->value => '⛈️',
        WeatherType::TRACE_RAIN->value => '🌧',
    ];
    public const array WEATHER_TYPE_NAMES = [
        WeatherType::CLEAR_NIGHT->value => 'Clear night',
        WeatherType::CLOUDY->value => 'Cloudy',
        WeatherType::DRIZZLE->value => 'Drizzle',
        WeatherType::FOG->value => 'Fog',
        WeatherType::HAIL->value => 'Hail',
        WeatherType::HAIL_SHOWER_DAY->value => 'Hail shower (day)',
        WeatherType::HAIL_SHOWER_NIGHT->value => 'Hail shower (night)',
        WeatherType::HEAVY_RAIN->value => 'Heavy rain',
        WeatherType::HEAVY_RAIN_SHOWER_DAY->value => 'Heavy rain shower (day)',
        WeatherType::HEAVY_RAIN_SHOWER_NIGHT->value => 'Heavy rain shower (night)',
        WeatherType::HEAVY_SNOW->value => 'Heavy snow',
        WeatherType::HEAVY_SNOW_SHOWER_DAY->value => 'Heavy snow shower (day)',
        WeatherType::HEAVY_SNOW_SHOWER_NIGHT->value => 'Heavy snow shower (night)',
        WeatherType::LIGHT_RAIN->value => 'Light rain',
        WeatherType::LIGHT_RAIN_SHOWER_DAY->value => 'Light rain shower (day)',
        WeatherType::LIGHT_RAIN_SHOWER_NIGHT->value => 'Light rain shower (night)',
        WeatherType::LIGHT_SNOW->value => 'Light snow',
        WeatherType::LIGHT_SNOW_SHOWER_DAY->value => 'Light snow shower (day)',
        WeatherType::LIGHT_SNOW_SHOWER_NIGHT->value => 'Light snow shower (night)',
        WeatherType::MIST->value => 'Mist',
        WeatherType::OVERCAST->value => 'Overcast',
        WeatherType::PARTLY_CLOUDY_DAY->value => 'Partly cloudy (day)',
        WeatherType::PARTLY_CLOUDY_NIGHT->value => 'Partly cloudy (night)',
        WeatherType::SLEET->value => 'Sleet',
        WeatherType::SLEET_SHOWER_DAY->value => 'Sleet shower (day)',
        WeatherType::SLEET_SHOWER_NIGHT->value => 'Sleet shower (night)',
        WeatherType::SUNNY_DAY->value => 'Sunny day',
        WeatherType::THUNDER->value => 'Thunder',
        WeatherType::THUNDER_SHOWER_DAY->value => 'Thunder shower (day)',
        WeatherType::THUNDER_SHOWER_NIGHT->value => 'Thunder shower (night)',
        WeatherType::TRACE_RAIN->value => 'Trace rain',
    ];

    public function transform(WeatherType $weatherType): ?string;

    public function transformToEmoji(WeatherType $weatherType): ?string;
}
