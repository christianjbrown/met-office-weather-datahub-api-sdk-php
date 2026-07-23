<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Parameter;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;

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
        $observedProperty = $data[self::KEY_OBSERVED_PROPERTY];
        if (!isset($observedProperty[self::KEY_LABEL])) {
            return;
        }
        if (!is_array($observedProperty[self::KEY_LABEL])) {
            return;
        }
        $label = $observedProperty[self::KEY_LABEL];
        if (empty($label[self::KEY_EN])) {
            return;
        }
        if (!is_string($label[self::KEY_EN])) {
            return;
        }
        $parameter->setObservedPropertyLabel($label[self::KEY_EN]);
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
}
