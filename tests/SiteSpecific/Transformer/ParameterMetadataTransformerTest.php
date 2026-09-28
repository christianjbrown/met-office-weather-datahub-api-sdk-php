<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadata;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ParameterMetadataTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ParameterMetadataTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParameterMetadata::class)]
#[CoversClass(ParameterMetadataTransformer::class)]
final class ParameterMetadataTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ParameterMetadataTransformerInterface::KEY_DESCRIPTION => 'test-description',
            ParameterMetadataTransformerInterface::KEY_TYPE => 'test-type',
            ParameterMetadataTransformerInterface::KEY_UNIT => [
                ParameterMetadataTransformerInterface::KEY_LABEL => 'test-unit-label',
                ParameterMetadataTransformerInterface::KEY_SYMBOL => [
                    ParameterMetadataTransformerInterface::KEY_TYPE => 'test-symbol-type',
                    ParameterMetadataTransformerInterface::KEY_VALUE => 'test-symbol-value',
                ],
            ],
        ];

        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform($data);

        self::assertSame('test-description', $actual->getDescription());
        self::assertSame('test-type', $actual->getType());
        self::assertSame('test-unit-label', $actual->getUnitLabel());
        self::assertSame('test-symbol-type', $actual->getUnitSymbolType());
        self::assertSame('test-symbol-value', $actual->getUnitSymbolValue());
    }

    public function testTransformMinimal(): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform([]);

        self::assertNull($actual->getDescription());
        self::assertNull($actual->getType());
        self::assertNull($actual->getUnitLabel());
        self::assertNull($actual->getUnitSymbolType());
        self::assertNull($actual->getUnitSymbolValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsDescriptionCases')]
    public function testTransformSkipsDescription(array $data): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform($data);

        self::assertNull($actual->getDescription());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsDescriptionCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_DESCRIPTION => '']];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_DESCRIPTION => 42]];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsTypeCases')]
    public function testTransformSkipsType(array $data): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform($data);

        self::assertNull($actual->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsTypeCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_TYPE => '']];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_TYPE => 42]];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsUnitCases')]
    public function testTransformSkipsUnit(array $data): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform($data);

        self::assertNull($actual->getUnitLabel());
        self::assertNull($actual->getUnitSymbolType());
        self::assertNull($actual->getUnitSymbolValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsUnitCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_UNIT => []]];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_UNIT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $unit
     */
    #[DataProvider('provideTransformSkipsUnitLabelCases')]
    public function testTransformSkipsUnitLabel(array $unit): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform([ParameterMetadataTransformerInterface::KEY_UNIT => $unit]);

        self::assertNull($actual->getUnitLabel());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsUnitLabelCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_LABEL => '']];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_LABEL => 42]];
    }

    /**
     * @param array<string, mixed> $unit
     */
    #[DataProvider('provideTransformSkipsUnitSymbolCases')]
    public function testTransformSkipsUnitSymbol(array $unit): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform([ParameterMetadataTransformerInterface::KEY_UNIT => $unit]);

        self::assertNull($actual->getUnitSymbolType());
        self::assertNull($actual->getUnitSymbolValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsUnitSymbolCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_SYMBOL => []]];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_SYMBOL => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $symbol
     */
    #[DataProvider('provideTransformSkipsUnitSymbolTypeCases')]
    public function testTransformSkipsUnitSymbolType(array $symbol): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform(
            [
                ParameterMetadataTransformerInterface::KEY_UNIT => [
                    ParameterMetadataTransformerInterface::KEY_SYMBOL => $symbol,
                ],
            ]
        );

        self::assertNull($actual->getUnitSymbolType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsUnitSymbolTypeCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_TYPE => '']];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_TYPE => 42]];
    }

    /**
     * @param array<string, mixed> $symbol
     */
    #[DataProvider('provideTransformSkipsUnitSymbolValueCases')]
    public function testTransformSkipsUnitSymbolValue(array $symbol): void
    {
        $transformer = new ParameterMetadataTransformer();
        $actual = $transformer->transform(
            [
                ParameterMetadataTransformerInterface::KEY_UNIT => [
                    ParameterMetadataTransformerInterface::KEY_SYMBOL => $symbol,
                ],
            ]
        );

        self::assertNull($actual->getUnitSymbolValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsUnitSymbolValueCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'empty' => [[ParameterMetadataTransformerInterface::KEY_VALUE => '']];
        yield 'wrongType' => [[ParameterMetadataTransformerInterface::KEY_VALUE => 42]];
    }
}
