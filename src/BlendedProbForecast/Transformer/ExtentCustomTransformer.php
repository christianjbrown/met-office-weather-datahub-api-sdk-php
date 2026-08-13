<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustom;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class ExtentCustomTransformer implements ExtentCustomTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtentCustomInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $extentCustom = new ExtentCustom($data[self::KEY_ID]);

        self::applyInterval($extentCustom, $data);
        self::applyReference($extentCustom, $data);
        self::applyValues($extentCustom, $data);

        return $extentCustom;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInterval(ExtentCustom $extentCustom, array $data): void
    {
        if (!isset($data[self::KEY_INTERVAL])) {
            return;
        }
        if (!is_array($data[self::KEY_INTERVAL])) {
            return;
        }
        $interval = $data[self::KEY_INTERVAL];
        if (!isset($interval[0])) {
            return;
        }
        if (!is_array($interval[0])) {
            return;
        }
        $extentCustom->setInterval(self::toStringArray($interval[0]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReference(ExtentCustom $extentCustom, array $data): void
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return;
        }
        $extentCustom->setReference($data[self::KEY_REFERENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValues(ExtentCustom $extentCustom, array $data): void
    {
        if (!isset($data[self::KEY_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUES])) {
            return;
        }
        $extentCustom->setValues(self::toStringArray($data[self::KEY_VALUES]));
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
