<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArray;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArrayInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class RangeTransformer implements RangeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NdArrayInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $ndArray = new NdArray($data[self::KEY_ID]);

        self::applyAxisNames($ndArray, $data);
        self::applyDataType($ndArray, $data);
        self::applyShape($ndArray, $data);
        self::applyValues($ndArray, $data);

        return $ndArray;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAxisNames(NdArray $ndArray, array $data): void
    {
        if (!isset($data[self::KEY_AXIS_NAMES])) {
            return;
        }
        if (!is_array($data[self::KEY_AXIS_NAMES])) {
            return;
        }
        $ndArray->setAxisNames(self::toStringArray($data[self::KEY_AXIS_NAMES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDataType(NdArray $ndArray, array $data): void
    {
        if (empty($data[self::KEY_DATA_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_DATA_TYPE])) {
            return;
        }
        $ndArray->setDataType($data[self::KEY_DATA_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShape(NdArray $ndArray, array $data): void
    {
        if (!isset($data[self::KEY_SHAPE])) {
            return;
        }
        if (!is_array($data[self::KEY_SHAPE])) {
            return;
        }
        $ndArray->setShape(self::toIntArray($data[self::KEY_SHAPE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValues(NdArray $ndArray, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $ndArray->setValues(self::toNullableFloatArray($data[self::KEY_VALUES]));
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
     * @return array<int, int>
     */
    private static function toIntArray(array $values): array
    {
        return array_values(array_filter($values, static fn (mixed $value): bool => is_int($value)));
    }

    /**
     * @param mixed[] $values
     *
     * @return array<int, null|float>
     */
    private static function toNullableFloatArray(array $values): array
    {
        return array_values(array_map(static fn (mixed $value): ?float => self::toFloat($value), $values));
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
