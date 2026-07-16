<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\ParameterDetail;
use ChristianBrown\MetOffice\AtmosphericModels\Model\ParameterDetailInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class ParameterDetailTransformer implements ParameterDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterDetailInterface
    {
        if (empty($data[self::KEY_PARAMETER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PARAMETER_ID));
        }
        if (!is_string($data[self::KEY_PARAMETER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PARAMETER_ID));
        }
        $parameterDetail = new ParameterDetail($data[self::KEY_PARAMETER_ID]);

        $this->applyTimeCoordinates($parameterDetail, $data);
        $this->applyVerticalCoordinates($parameterDetail, $data);

        return $parameterDetail;
    }

    private function applyTimeCoordinates(ParameterDetail $parameterDetail, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $extent = $data[self::KEY_EXTENT];
        if (!isset($extent[self::KEY_TIME])) {
            return;
        }
        if (!is_array($extent[self::KEY_TIME])) {
            return;
        }
        $parameterDetail->setTimeCoordinates($this->toStringArray($extent[self::KEY_TIME]));
    }

    private function applyVerticalCoordinates(ParameterDetail $parameterDetail, array $data): void
    {
        if (!isset($data[self::KEY_EXTENT])) {
            return;
        }
        if (!is_array($data[self::KEY_EXTENT])) {
            return;
        }
        $extent = $data[self::KEY_EXTENT];
        if (!isset($extent[self::KEY_VERTICAL])) {
            return;
        }
        if (!is_array($extent[self::KEY_VERTICAL])) {
            return;
        }
        $parameterDetail->setVerticalCoordinates($this->toFloatArray($extent[self::KEY_VERTICAL]));
    }

    private function toFloat(mixed $value): ?float
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
    private function toFloatArray(array $values): array
    {
        $floats = array_map(fn (mixed $value): ?float => $this->toFloat($value), $values);

        return array_values(array_filter($floats, static fn (?float $value): bool => null !== $value));
    }

    /**
     * @param mixed[] $values
     *
     * @return array<int, string>
     */
    private function toStringArray(array $values): array
    {
        return array_values(array_filter($values, static fn (mixed $value): bool => is_string($value)));
    }
}
