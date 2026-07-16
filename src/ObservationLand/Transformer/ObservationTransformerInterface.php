<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;

interface ObservationTransformerInterface
{
    public const KEY_DATETIME = 'datetime';
    public const KEY_HUMIDITY = 'humidity';
    public const KEY_MSLP = 'mslp';
    public const KEY_PRESSURE_TENDENCY = 'pressure_tendency';
    public const KEY_TEMPERATURE = 'temperature';
    public const KEY_VISIBILITY = 'visibility';
    public const KEY_WEATHER_CODE = 'weather_code';
    public const KEY_WIND_DIRECTION = 'wind_direction';
    public const KEY_WIND_GUST = 'wind_gust';
    public const KEY_WIND_SPEED = 'wind_speed';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ObservationInterface;
}
