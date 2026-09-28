<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadata;
use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadataInterface;

use function is_array;
use function is_string;

final class ParameterMetadataTransformer implements ParameterMetadataTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterMetadataInterface
    {
        $parameterMetadata = new ParameterMetadata();

        self::applyDescription($parameterMetadata, $data);
        self::applyType($parameterMetadata, $data);
        self::applyUnit($parameterMetadata, $data);

        return $parameterMetadata;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(ParameterMetadata $parameterMetadata, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $parameterMetadata->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(ParameterMetadata $parameterMetadata, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $parameterMetadata->setType($data[self::KEY_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(ParameterMetadata $parameterMetadata, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_array($data[self::KEY_UNIT])) {
            return;
        }
        $unit = $data[self::KEY_UNIT];
        self::applyUnitLabel($parameterMetadata, $unit);
        self::applyUnitSymbol($parameterMetadata, $unit);
    }

    /**
     * @phpstan-param mixed[] $unit
     */
    private static function applyUnitLabel(ParameterMetadata $parameterMetadata, array $unit): void
    {
        if (empty($unit[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($unit[self::KEY_LABEL])) {
            return;
        }
        $parameterMetadata->setUnitLabel($unit[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $unit
     */
    private static function applyUnitSymbol(ParameterMetadata $parameterMetadata, array $unit): void
    {
        if (empty($unit[self::KEY_SYMBOL])) {
            return;
        }
        if (!is_array($unit[self::KEY_SYMBOL])) {
            return;
        }
        $symbol = $unit[self::KEY_SYMBOL];
        self::applyUnitSymbolType($parameterMetadata, $symbol);
        self::applyUnitSymbolValue($parameterMetadata, $symbol);
    }

    /**
     * @phpstan-param mixed[] $symbol
     */
    private static function applyUnitSymbolType(ParameterMetadata $parameterMetadata, array $symbol): void
    {
        if (empty($symbol[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($symbol[self::KEY_TYPE])) {
            return;
        }
        $parameterMetadata->setUnitSymbolType($symbol[self::KEY_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $symbol
     */
    private static function applyUnitSymbolValue(ParameterMetadata $parameterMetadata, array $symbol): void
    {
        if (empty($symbol[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($symbol[self::KEY_VALUE])) {
            return;
        }
        $parameterMetadata->setUnitSymbolValue($symbol[self::KEY_VALUE]);
    }
}
