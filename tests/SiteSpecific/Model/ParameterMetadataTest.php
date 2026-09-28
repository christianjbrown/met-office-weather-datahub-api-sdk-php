<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Model;

use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadata;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParameterMetadata::class)]
final class ParameterMetadataTest extends TestCase
{
    public function test(): void
    {
        $parameterMetadata = new ParameterMetadata();
        self::assertNull($parameterMetadata->getDescription());
        self::assertNull($parameterMetadata->getType());
        self::assertNull($parameterMetadata->getUnitLabel());
        self::assertNull($parameterMetadata->getUnitSymbolType());
        self::assertNull($parameterMetadata->getUnitSymbolValue());

        self::assertSame($parameterMetadata, $parameterMetadata->setDescription('test-description'));
        self::assertSame($parameterMetadata, $parameterMetadata->setType('test-type'));
        self::assertSame($parameterMetadata, $parameterMetadata->setUnitLabel('test-unit-label'));
        self::assertSame($parameterMetadata, $parameterMetadata->setUnitSymbolType('test-symbol-type'));
        self::assertSame($parameterMetadata, $parameterMetadata->setUnitSymbolValue('test-symbol-value'));

        self::assertSame('test-description', $parameterMetadata->getDescription());
        self::assertSame('test-type', $parameterMetadata->getType());
        self::assertSame('test-unit-label', $parameterMetadata->getUnitLabel());
        self::assertSame('test-symbol-type', $parameterMetadata->getUnitSymbolType());
        self::assertSame('test-symbol-value', $parameterMetadata->getUnitSymbolValue());
    }
}
