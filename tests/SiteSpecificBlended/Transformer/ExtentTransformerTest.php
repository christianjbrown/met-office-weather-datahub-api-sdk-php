<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Extent;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ExtentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Extent::class)]
#[CoversClass(ExtentTransformer::class)]
final class ExtentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ExtentTransformerInterface::KEY_SPATIAL => [
                ExtentTransformerInterface::KEY_BBOX => [-8.0, 49.0, 2, 61.0],
                ExtentTransformerInterface::KEY_CRS => 'CRS84',
            ],
            ExtentTransformerInterface::KEY_TEMPORAL => [
                ExtentTransformerInterface::KEY_INTERVAL => [['2024-03-08T00:00:00Z', '2024-03-15T00:00:00Z']],
                ExtentTransformerInterface::KEY_VALUES => ['2024-03-08T00:00:00Z', 42],
            ],
            ExtentTransformerInterface::KEY_VERTICAL => [
                ExtentTransformerInterface::KEY_VALUES => [1.5, 10, 'not-a-number'],
            ],
        ];

        $extent = (new ExtentTransformer())->transform($data);

        self::assertSame([-8.0, 49.0, 2.0, 61.0], $extent->getSpatialBbox());
        self::assertSame('CRS84', $extent->getSpatialCrs());
        self::assertSame(['2024-03-08T00:00:00Z', '2024-03-15T00:00:00Z'], $extent->getTemporalInterval());
        self::assertSame(['2024-03-08T00:00:00Z'], $extent->getTemporalValues());
        self::assertSame([1.5, 10.0], $extent->getVerticalValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $extent = (new ExtentTransformer())->transform($data);

        self::assertSame([], $extent->getSpatialBbox());
        self::assertNull($extent->getSpatialCrs());
        self::assertSame([], $extent->getTemporalInterval());
        self::assertSame([], $extent->getTemporalValues());
        self::assertSame([], $extent->getVerticalValues());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'empty' => [[]];
        yield 'topLevelWrongTypes' => [
            [
                ExtentTransformerInterface::KEY_SPATIAL => 42,
                ExtentTransformerInterface::KEY_TEMPORAL => 42,
                ExtentTransformerInterface::KEY_VERTICAL => 42,
            ],
        ];
        yield 'emptyContainers' => [
            [
                ExtentTransformerInterface::KEY_SPATIAL => [],
                ExtentTransformerInterface::KEY_TEMPORAL => [],
                ExtentTransformerInterface::KEY_VERTICAL => [],
            ],
        ];
        yield 'innerWrongTypes' => [
            [
                ExtentTransformerInterface::KEY_SPATIAL => [
                    ExtentTransformerInterface::KEY_BBOX => 42,
                    ExtentTransformerInterface::KEY_CRS => 42,
                ],
                ExtentTransformerInterface::KEY_TEMPORAL => [
                    ExtentTransformerInterface::KEY_INTERVAL => 42,
                    ExtentTransformerInterface::KEY_VALUES => 42,
                ],
                ExtentTransformerInterface::KEY_VERTICAL => [
                    ExtentTransformerInterface::KEY_VALUES => 42,
                ],
            ],
        ];
        yield 'intervalEmpty' => [
            [
                ExtentTransformerInterface::KEY_TEMPORAL => [
                    ExtentTransformerInterface::KEY_INTERVAL => [],
                ],
            ],
        ];
        yield 'intervalWrongFirst' => [
            [
                ExtentTransformerInterface::KEY_TEMPORAL => [
                    ExtentTransformerInterface::KEY_INTERVAL => [42],
                ],
            ],
        ];
    }
}
