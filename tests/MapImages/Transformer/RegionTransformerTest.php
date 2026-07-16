<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\AxisExtentInterface;
use ChristianBrown\MetOffice\MapImages\Model\Region;
use ChristianBrown\MetOffice\MapImages\Transformer\AxisExtentTransformerInterface;
use ChristianBrown\MetOffice\MapImages\Transformer\RegionTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RegionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Region::class)]
#[CoversClass(RegionTransformer::class)]
final class RegionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $xData = ['x-axis-filler'];
        $yData = ['y-axis-filler'];
        $data = [
            RegionTransformerInterface::KEY_NAME => 'Europe',
            RegionTransformerInterface::KEY_EXTENT => [
                RegionTransformerInterface::KEY_X => $xData,
                RegionTransformerInterface::KEY_Y => $yData,
            ],
        ];

        $xAxis = self::createStub(AxisExtentInterface::class);
        $yAxis = self::createStub(AxisExtentInterface::class);

        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);
        $axisExtentTransformer->method('transform')
            ->willReturnMap(
                [
                    [$xData, $xAxis],
                    [$yData, $yAxis],
                ]
            );

        $transformer = new RegionTransformer($axisExtentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('Europe', $actual->getName());
        self::assertSame($xAxis, $actual->getX());
        self::assertSame($yAxis, $actual->getY());
    }

    public function testTransformMinimal(): void
    {
        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);

        $transformer = new RegionTransformer($axisExtentTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getX());
        self::assertNull($actual->getY());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsNameCases')]
    public function testTransformSkipsName(array $data): void
    {
        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);

        $transformer = new RegionTransformer($axisExtentTransformer);

        self::assertNull($transformer->transform($data)->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsNameCases(): iterable
    {
        yield 'nameAbsent' => [[]];
        yield 'nameWrongType' => [[RegionTransformerInterface::KEY_NAME => 42]];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsExtentCases')]
    public function testTransformSkipsX(array $data): void
    {
        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);

        $transformer = new RegionTransformer($axisExtentTransformer);

        self::assertNull($transformer->transform($data)->getX());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsExtentCases')]
    public function testTransformSkipsY(array $data): void
    {
        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);

        $transformer = new RegionTransformer($axisExtentTransformer);

        self::assertNull($transformer->transform($data)->getY());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsExtentCases(): iterable
    {
        yield 'extentAbsent' => [[]];
        yield 'extentWrongType' => [[RegionTransformerInterface::KEY_EXTENT => 'not-an-array']];
        yield 'axisAbsent' => [[RegionTransformerInterface::KEY_EXTENT => ['filler' => 1]]];
        yield 'xWrongType' => [[RegionTransformerInterface::KEY_EXTENT => [RegionTransformerInterface::KEY_X => 'not-an-array']]];
    }

    public function testTransformSkipsYWhenYWrongType(): void
    {
        $data = [
            RegionTransformerInterface::KEY_EXTENT => [
                RegionTransformerInterface::KEY_Y => 'not-an-array',
            ],
        ];

        $axisExtentTransformer = self::createStub(AxisExtentTransformerInterface::class);

        $transformer = new RegionTransformer($axisExtentTransformer);

        self::assertNull($transformer->transform($data)->getY());
    }
}
