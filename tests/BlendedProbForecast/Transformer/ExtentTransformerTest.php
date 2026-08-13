<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Extent;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(Extent::class)]
#[CoversClass(ExtentTransformer::class)]
final class ExtentTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $customData = [
            [
                'id' => 'percentile',
            ],
        ];
        $data = [
            ExtentTransformerInterface::KEY_CUSTOM => $customData,
            ExtentTransformerInterface::KEY_SPATIAL => [
                ExtentTransformerInterface::KEY_BBOX => [[-8.0, 49.0, 2, 61.0]],
                ExtentTransformerInterface::KEY_CRS => 'CRS84',
            ],
            ExtentTransformerInterface::KEY_TEMPORAL => [
                ExtentTransformerInterface::KEY_INTERVAL => [['2026-08-12T15:00:00Z', '2026-08-27T00:00:00Z']],
                ExtentTransformerInterface::KEY_VALUES => ['2026-08-12T15:00:00Z', 42],
            ],
            ExtentTransformerInterface::KEY_VERTICAL => [
                ExtentTransformerInterface::KEY_VALUES => [1.5, 10, 'not-a-number'],
            ],
        ];

        $custom = [self::createStub(ExtentCustomInterface::class)];

        $extentCustomsTransformer = self::createMock(ExtentCustomsTransformerInterface::class);
        $extentCustomsTransformer->expects(self::once())
            ->method('transform')
            ->with($customData)
            ->willReturn($custom);

        $extent = (new ExtentTransformer($extentCustomsTransformer))->transform($data);

        self::assertSame($custom, $extent->getCustom());
        self::assertSame([-8.0, 49.0, 2.0, 61.0], $extent->getSpatialBbox());
        self::assertSame('CRS84', $extent->getSpatialCrs());
        self::assertSame(['2026-08-12T15:00:00Z', '2026-08-27T00:00:00Z'], $extent->getTemporalInterval());
        self::assertSame(['2026-08-12T15:00:00Z'], $extent->getTemporalValues());
        self::assertSame([1.5, 10.0], $extent->getVerticalValues());
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws Exception
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $extentCustomsTransformer = self::createMock(ExtentCustomsTransformerInterface::class);
        $extentCustomsTransformer->expects(self::never())
            ->method('transform');

        $extent = (new ExtentTransformer($extentCustomsTransformer))->transform($data);

        self::assertSame([], $extent->getCustom());
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
                ExtentTransformerInterface::KEY_CUSTOM => 42,
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
        yield 'bboxEmpty' => [
            [
                ExtentTransformerInterface::KEY_SPATIAL => [
                    ExtentTransformerInterface::KEY_BBOX => [],
                ],
            ],
        ];
        yield 'bboxWrongFirst' => [
            [
                ExtentTransformerInterface::KEY_SPATIAL => [
                    ExtentTransformerInterface::KEY_BBOX => [42],
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
