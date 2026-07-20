<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocation;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

use function is_string;
use function sprintf;

final class NearestLocationTransformer implements NearestLocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NearestLocationInterface
    {
        if (empty($data[self::KEY_GEOHASH])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_GEOHASH));
        }
        if (!is_string($data[self::KEY_GEOHASH])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_GEOHASH));
        }
        $location = new NearestLocation($data[self::KEY_GEOHASH]);

        $this->applyArea($location, $data);
        $this->applyCountry($location, $data);
        $this->applyOlsonTimeZone($location, $data);
        $this->applyRegion($location, $data);

        return $location;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyArea(NearestLocation $location, array $data): void
    {
        if (empty($data[self::KEY_AREA])) {
            return;
        }
        if (!is_string($data[self::KEY_AREA])) {
            return;
        }
        $location->setArea($data[self::KEY_AREA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCountry(NearestLocation $location, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $location->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOlsonTimeZone(NearestLocation $location, array $data): void
    {
        if (empty($data[self::KEY_OLSON_TIME_ZONE])) {
            return;
        }
        if (!is_string($data[self::KEY_OLSON_TIME_ZONE])) {
            return;
        }
        $location->setOlsonTimeZone($data[self::KEY_OLSON_TIME_ZONE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegion(NearestLocation $location, array $data): void
    {
        if (empty($data[self::KEY_REGION])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION])) {
            return;
        }
        $location->setRegion($data[self::KEY_REGION]);
    }
}
