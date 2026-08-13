<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystem;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ReferenceSystem::class)]
#[CoversClass(ReferenceSystemTransformer::class)]
final class ReferenceSystemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles', 42],
            ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                ReferenceSystemTransformerInterface::KEY_TYPE => 'IdentifierRS',
                ReferenceSystemTransformerInterface::KEY_LABEL => [
                    ReferenceSystemTransformerInterface::KEY_EN => 'percentiles',
                ],
                ReferenceSystemTransformerInterface::KEY_IDENTIFIERS => [
                    '5' => [
                        ReferenceSystemTransformerInterface::KEY_LABEL => [
                            ReferenceSystemTransformerInterface::KEY_EN => '5th percentile',
                        ],
                    ],
                    '95' => [
                        ReferenceSystemTransformerInterface::KEY_LABEL => [
                            ReferenceSystemTransformerInterface::KEY_EN => '95th percentile',
                        ],
                    ],
                    'skipped-not-an-array' => 42,
                    'skipped-no-label' => [],
                ],
            ],
        ];

        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertNull($referenceSystem->getCalendar());
        self::assertSame(['percentiles'], $referenceSystem->getCoordinates());
        self::assertNull($referenceSystem->getId());
        self::assertSame(['5' => '5th percentile', '95' => '95th percentile'], $referenceSystem->getIdentifiers());
        self::assertSame('percentiles', $referenceSystem->getLabel());
        self::assertSame('IdentifierRS', $referenceSystem->getType());
    }

    public function testTransformIdentifiersEmpty(): void
    {
        $data = [
            ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
            ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                ReferenceSystemTransformerInterface::KEY_IDENTIFIERS => [],
            ],
        ];

        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertSame([], $referenceSystem->getIdentifiers());
    }

    public function testTransformSingleIdentifier(): void
    {
        $data = [
            ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
            ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                ReferenceSystemTransformerInterface::KEY_IDENTIFIERS => [
                    '50' => [
                        ReferenceSystemTransformerInterface::KEY_LABEL => [
                            ReferenceSystemTransformerInterface::KEY_EN => '50th percentile',
                        ],
                    ],
                ],
            ],
        ];

        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertSame(['50' => '50th percentile'], $referenceSystem->getIdentifiers());
    }

    public function testTransformSingleSkippedIdentifier(): void
    {
        $data = [
            ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
            ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                ReferenceSystemTransformerInterface::KEY_IDENTIFIERS => [
                    'skipped' => 42,
                ],
            ],
        ];

        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertSame([], $referenceSystem->getIdentifiers());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertNull($referenceSystem->getCalendar());
        self::assertNull($referenceSystem->getId());
        self::assertSame([], $referenceSystem->getIdentifiers());
        self::assertNull($referenceSystem->getLabel());
        self::assertNull($referenceSystem->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'noSystem' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
            ],
        ];
        yield 'systemWrongType' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
                ReferenceSystemTransformerInterface::KEY_SYSTEM => 42,
            ],
        ];
        yield 'systemEmpty' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
                ReferenceSystemTransformerInterface::KEY_SYSTEM => [],
            ],
        ];
        yield 'systemWrongTypes' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
                ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                    ReferenceSystemTransformerInterface::KEY_CALENDAR => 42,
                    ReferenceSystemTransformerInterface::KEY_ID => 42,
                    ReferenceSystemTransformerInterface::KEY_IDENTIFIERS => 42,
                    ReferenceSystemTransformerInterface::KEY_LABEL => 42,
                    ReferenceSystemTransformerInterface::KEY_TYPE => 42,
                ],
            ],
        ];
        yield 'labelEmpty' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
                ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                    ReferenceSystemTransformerInterface::KEY_LABEL => [],
                ],
            ],
        ];
        yield 'labelMissingEnglish' => [
            [
                ReferenceSystemTransformerInterface::KEY_COORDINATES => ['percentiles'],
                ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                    ReferenceSystemTransformerInterface::KEY_LABEL => [
                        ReferenceSystemTransformerInterface::KEY_EN => 42,
                    ],
                ],
            ],
        ];
    }

    public function testTransformTemporal(): void
    {
        $data = [
            ReferenceSystemTransformerInterface::KEY_COORDINATES => ['t'],
            ReferenceSystemTransformerInterface::KEY_SYSTEM => [
                ReferenceSystemTransformerInterface::KEY_CALENDAR => 'Gregorian',
                ReferenceSystemTransformerInterface::KEY_ID => 'https://www.opengis.net/def/crs/EPSG/0/4979',
                ReferenceSystemTransformerInterface::KEY_TYPE => 'TemporalRS',
            ],
        ];

        $referenceSystem = (new ReferenceSystemTransformer())->transform($data);

        self::assertSame('Gregorian', $referenceSystem->getCalendar());
        self::assertSame(['t'], $referenceSystem->getCoordinates());
        self::assertSame('https://www.opengis.net/def/crs/EPSG/0/4979', $referenceSystem->getId());
        self::assertSame([], $referenceSystem->getIdentifiers());
        self::assertNull($referenceSystem->getLabel());
        self::assertSame('TemporalRS', $referenceSystem->getType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[TestWith([[]])]
    #[TestWith([[ReferenceSystemTransformerInterface::KEY_COORDINATES => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ReferenceSystemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ReferenceSystemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ReferenceSystemTransformerInterface::KEY_COORDINATES));
        $transformer->transform($data);
    }
}
