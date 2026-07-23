<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Axis;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\AxisInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class AxisTransformer implements AxisTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AxisInterface
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        $axis = new Axis($data[self::KEY_NAME]);

        self::applyValues($axis, $data);

        return $axis;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValues(Axis $axis, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $values = $data[self::KEY_VALUES];
        $axis->setFloatValues(self::toFloatArray($values));
        $axis->setStringValues(self::toStringArray($values));
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
