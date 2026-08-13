<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Parameter;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function is_string;
use function sprintf;

final class ParameterTransformer implements ParameterTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $parameter = new Parameter($data[self::KEY_ID]);

        self::applyDescription($parameter, $data);
        self::applyFileSuffix($parameter, $data);
        self::applyHeight($parameter, $data);
        self::applyObservedPropertyId($parameter, $data);
        self::applyObservedPropertyLabel($parameter, $data);
        self::applyUnit($parameter, $data);

        return $parameter;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Parameter $parameter, array $data): void
    {
        if (!isset($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_array($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $description = $data[self::KEY_DESCRIPTION];
        if (empty($description[self::KEY_EN])) {
            return;
        }
        if (!is_string($description[self::KEY_EN])) {
            return;
        }
        $parameter->setDescription($description[self::KEY_EN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFileSuffix(Parameter $parameter, array $data): void
    {
        $label = self::extractCustomLabel($data, self::KEY_FILE_SUFFIX);
        if (null === $label) {
            return;
        }
        $parameter->setFileSuffix($label);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHeight(Parameter $parameter, array $data): void
    {
        $label = self::extractCustomLabel($data, self::KEY_HEIGHT);
        if (null === $label) {
            return;
        }
        $parameter->setHeight($label);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyObservedPropertyId(Parameter $parameter, array $data): void
    {
        if (!isset($data[self::KEY_OBSERVED_PROPERTY])) {
            return;
        }
        if (!is_array($data[self::KEY_OBSERVED_PROPERTY])) {
            return;
        }
        $observedProperty = $data[self::KEY_OBSERVED_PROPERTY];
        if (empty($observedProperty[self::KEY_ID])) {
            return;
        }
        if (!is_string($observedProperty[self::KEY_ID])) {
            return;
        }
        $parameter->setObservedPropertyId($observedProperty[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyObservedPropertyLabel(Parameter $parameter, array $data): void
    {
        if (!isset($data[self::KEY_OBSERVED_PROPERTY])) {
            return;
        }
        if (!is_array($data[self::KEY_OBSERVED_PROPERTY])) {
            return;
        }
        $label = self::extractEnglishLabel($data[self::KEY_OBSERVED_PROPERTY]);
        if (null === $label) {
            return;
        }
        $parameter->setObservedPropertyLabel($label);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(Parameter $parameter, array $data): void
    {
        if (!isset($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_array($data[self::KEY_UNIT])) {
            return;
        }
        $unit = $data[self::KEY_UNIT];
        if (empty($unit[self::KEY_SYMBOL])) {
            return;
        }
        if (!is_string($unit[self::KEY_SYMBOL])) {
            return;
        }
        $parameter->setUnit($unit[self::KEY_SYMBOL]);
    }

    /**
     * @phpstan-param mixed[] $data
     *
     * @return null|mixed[]
     */
    private static function extractCustomEntry(array $data, string $key): ?array
    {
        if (!isset($data[self::KEY_CUSTOM])) {
            return null;
        }
        if (!is_array($data[self::KEY_CUSTOM])) {
            return null;
        }
        $custom = $data[self::KEY_CUSTOM];
        if (!isset($custom[$key])) {
            return null;
        }
        if (!is_array($custom[$key])) {
            return null;
        }

        return $custom[$key];
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function extractCustomLabel(array $data, string $key): ?string
    {
        $entry = self::extractCustomEntry($data, $key);
        if (null === $entry) {
            return null;
        }

        return self::extractEnglishLabel($entry);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function extractEnglishLabel(array $data): ?string
    {
        if (!isset($data[self::KEY_LABEL])) {
            return null;
        }
        if (!is_array($data[self::KEY_LABEL])) {
            return null;
        }
        $label = $data[self::KEY_LABEL];
        if (empty($label[self::KEY_EN])) {
            return null;
        }
        if (!is_string($label[self::KEY_EN])) {
            return null;
        }

        return $label[self::KEY_EN];
    }
}
