<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

interface NearestLocationTransformerInterface
{
    public const string KEY_AREA = 'area';
    public const string KEY_COUNTRY = 'country';
    public const string KEY_GEOHASH = 'geohash';
    public const string KEY_OLSON_TIME_ZONE = 'olson_time_zone';
    public const string KEY_REGION = 'region';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NearestLocationInterface;
}
