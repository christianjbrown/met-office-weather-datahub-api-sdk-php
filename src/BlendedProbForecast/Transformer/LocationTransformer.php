<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Location;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LocationInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

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

        self::applyAltitude($location, $data);
        self::applyLatitude($location, $data);
        self::applyLongitude($location, $data);

        return $location;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAltitude(Location $location, array $data): void
    {
        $value = self::extractCoordinate($data, 2);
        if (null === $value) {
            return;
        }
        $location->setAltitude($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLatitude(Location $location, array $data): void
    {
        $value = self::extractCoordinate($data, 1);
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
        $value = self::extractCoordinate($data, 0);
        if (null === $value) {
            return;
        }
        $location->setLongitude($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function extractCoordinate(array $data, int $index): ?float
    {
        if (!isset($data[self::KEY_GEOMETRY])) {
            return null;
        }
        if (!is_array($data[self::KEY_GEOMETRY])) {
            return null;
        }
        $geometry = $data[self::KEY_GEOMETRY];
        if (!isset($geometry[self::KEY_COORDINATES])) {
            return null;
        }
        if (!is_array($geometry[self::KEY_COORDINATES])) {
            return null;
        }
        $coordinates = $geometry[self::KEY_COORDINATES];
        if (!isset($coordinates[$index])) {
            return null;
        }

        return self::toFloat($coordinates[$index]);
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
