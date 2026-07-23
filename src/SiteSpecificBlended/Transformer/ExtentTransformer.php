<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Extent;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ExtentInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_float;
use function is_int;
use function is_string;

final class ExtentTransformer implements ExtentTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtentInterface
    {
        $extent = new Extent();

        self::applySpatialBbox($extent, $data);
        self::applySpatialCrs($extent, $data);
        self::applyTemporalInterval($extent, $data);
        self::applyTemporalValues($extent, $data);
        self::applyVerticalValues($extent, $data);

        return $extent;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySpatialBbox(Extent $extent, array $data): void
    {
        if (!isset($data[self::KEY_SPATIAL])) {
            return;
        }
        if (!is_array($data[self::KEY_SPATIAL])) {
            return;
        }
        $spatial = $data[self::KEY_SPATIAL];
        if (!isset($spatial[self::KEY_BBOX])) {
            return;
        }
        if (!is_array($spatial[self::KEY_BBOX])) {
            return;
        }
        $extent->setSpatialBbox(self::toFloatArray($spatial[self::KEY_BBOX]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySpatialCrs(Extent $extent, array $data): void
    {
        if (!isset($data[self::KEY_SPATIAL])) {
            return;
        }
        if (!is_array($data[self::KEY_SPATIAL])) {
            return;
        }
        $spatial = $data[self::KEY_SPATIAL];
        if (empty($spatial[self::KEY_CRS])) {
            return;
        }
        if (!is_string($spatial[self::KEY_CRS])) {
            return;
        }
        $extent->setSpatialCrs($spatial[self::KEY_CRS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTemporalInterval(Extent $extent, array $data): void
    {
        if (!isset($data[self::KEY_TEMPORAL])) {
            return;
        }
        if (!is_array($data[self::KEY_TEMPORAL])) {
            return;
        }
        $temporal = $data[self::KEY_TEMPORAL];
        if (!isset($temporal[self::KEY_INTERVAL])) {
            return;
        }
        if (!is_array($temporal[self::KEY_INTERVAL])) {
            return;
        }
        $interval = $temporal[self::KEY_INTERVAL];
        if (!isset($interval[0])) {
            return;
        }
        if (!is_array($interval[0])) {
            return;
        }
        $extent->setTemporalInterval(self::toStringArray($interval[0]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTemporalValues(Extent $extent, array $data): void
    {
        if (!isset($data[self::KEY_TEMPORAL])) {
            return;
        }
        if (!is_array($data[self::KEY_TEMPORAL])) {
            return;
        }
        $temporal = $data[self::KEY_TEMPORAL];
        if (!isset($temporal[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($temporal[self::KEY_VALUES])) {
            return;
        }
        $extent->setTemporalValues(self::toStringArray($temporal[self::KEY_VALUES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVerticalValues(Extent $extent, array $data): void
    {
        if (!isset($data[self::KEY_VERTICAL])) {
            return;
        }
        if (!is_array($data[self::KEY_VERTICAL])) {
            return;
        }
        $vertical = $data[self::KEY_VERTICAL];
        if (!isset($vertical[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($vertical[self::KEY_VALUES])) {
            return;
        }
        $extent->setVerticalValues(self::toFloatArray($vertical[self::KEY_VALUES]));
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

    /**
     * @param mixed[] $values
     *
     * @return array<int, float>
     */
    private static function toFloatArray(array $values): array
    {
        $floats = array_map(static fn (mixed $value): ?float => self::toFloat($value), $values);

        return array_values(array_filter($floats, static fn (?float $value): bool => null !== $value));
    }

    /**
     * @param mixed[] $values
     *
     * @return array<int, string>
     */
    private static function toStringArray(array $values): array
    {
        return array_values(array_filter($values, static fn (mixed $value): bool => is_string($value)));
    }
}
