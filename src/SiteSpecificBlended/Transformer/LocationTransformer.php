<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Location;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;

use function is_array;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class LocationTransformer implements LocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $location = new Location($data[self::KEY_ID]);

        self::applyLatitude($location, $data);
        self::applyLongitude($location, $data);
        self::applyName($location, $data);

        return $location;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLatitude(Location $location, array $data): void
    {
        if (!isset($data[self::KEY_GEOMETRY])) {
            return;
        }
        if (!is_array($data[self::KEY_GEOMETRY])) {
            return;
        }
        $geometry = $data[self::KEY_GEOMETRY];
        if (!isset($geometry[self::KEY_COORDINATES])) {
            return;
        }
        if (!is_array($geometry[self::KEY_COORDINATES])) {
            return;
        }
        $coordinates = $geometry[self::KEY_COORDINATES];
        if (!isset($coordinates[1])) {
            return;
        }
        $value = self::toFloat($coordinates[1]);
        if (null === $value) {
            return;
        }
        $location->setLatitude($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLongitude(Location $location, array $data): void
    {
        if (!isset($data[self::KEY_GEOMETRY])) {
            return;
        }
        if (!is_array($data[self::KEY_GEOMETRY])) {
            return;
        }
        $geometry = $data[self::KEY_GEOMETRY];
        if (!isset($geometry[self::KEY_COORDINATES])) {
            return;
        }
        if (!is_array($geometry[self::KEY_COORDINATES])) {
            return;
        }
        $coordinates = $geometry[self::KEY_COORDINATES];
        if (!isset($coordinates[0])) {
            return;
        }
        $value = self::toFloat($coordinates[0]);
        if (null === $value) {
            return;
        }
        $location->setLongitude($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Location $location, array $data): void
    {
        if (!isset($data[self::KEY_PROPERTIES])) {
            return;
        }
        if (!is_array($data[self::KEY_PROPERTIES])) {
            return;
        }
        $properties = $data[self::KEY_PROPERTIES];
        if (empty($properties[self::KEY_NAME])) {
            return;
        }
        if (!is_string($properties[self::KEY_NAME])) {
            return;
        }
        $location->setName($properties[self::KEY_NAME]);
    }

    private static function toFloat(mixed $value): ?float
    {
        if (is_int($value)) {
            return (float) $value;
        }
        if (is_float($value)) {
            return $value;
        }

        return null;
    }
}
