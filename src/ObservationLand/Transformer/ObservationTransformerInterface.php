<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;

interface ObservationTransformerInterface
{
    public const string KEY_DATETIME = 'datetime';
    public const string KEY_HUMIDITY = 'humidity';
    public const string KEY_MSLP = 'mslp';
    public const string KEY_PRESSURE_TENDENCY = 'pressure_tendency';
    public const string KEY_TEMPERATURE = 'temperature';
    public const string KEY_VISIBILITY = 'visibility';
    public const string KEY_WEATHER_CODE = 'weather_code';
    public const string KEY_WIND_DIRECTION = 'wind_direction';
    public const string KEY_WIND_GUST = 'wind_gust';
    public const string KEY_WIND_SPEED = 'wind_speed';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const string UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ObservationInterface;
}
