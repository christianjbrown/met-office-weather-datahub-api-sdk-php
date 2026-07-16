<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

interface NearestLocationTransformerInterface
{
    public const KEY_AREA = 'area';
    public const KEY_COUNTRY = 'country';
    public const KEY_GEOHASH = 'geohash';
    public const KEY_OLSON_TIME_ZONE = 'olson_time_zone';
    public const KEY_REGION = 'region';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NearestLocationInterface;
}
