<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Parameter;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParameterTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Parameter::class)]
#[CoversClass(ParameterTransformer::class)]
final class ParameterTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ParameterTransformerInterface::KEY_ID => 'airPressureAtSeaLevel',
            ParameterTransformerInterface::KEY_DESCRIPTION => [
                ParameterTransformerInterface::KEY_EN => 'Air pressure at sea level',
            ],
            ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => [
                ParameterTransformerInterface::KEY_ID => 'https://example.com/def/air_pressure_at_sea_level',
                ParameterTransformerInterface::KEY_LABEL => [
                    ParameterTransformerInterface::KEY_EN => 'air_pressure_at_sea_level',
                ],
            ],
            ParameterTransformerInterface::KEY_UNIT => [
                ParameterTransformerInterface::KEY_SYMBOL => 'Pa',
            ],
            ParameterTransformerInterface::KEY_CUSTOM => [
                ParameterTransformerInterface::KEY_FILE_SUFFIX => [
                    ParameterTransformerInterface::KEY_LABEL => [
                        ParameterTransformerInterface::KEY_EN => 'temperature_at_screen_level.nc',
                    ],
                ],
                ParameterTransformerInterface::KEY_HEIGHT => [
                    ParameterTransformerInterface::KEY_LABEL => [
                        ParameterTransformerInterface::KEY_EN => 'height 1.5m',
                    ],
                ],
            ],
        ];

        $parameter = (new ParameterTransformer())->transform($data);

        self::assertSame('airPressureAtSeaLevel', $parameter->getId());
        self::assertSame('Air pressure at sea level', $parameter->getDescription());
        self::assertSame('temperature_at_screen_level.nc', $parameter->getFileSuffix());
        self::assertSame('height 1.5m', $parameter->getHeight());
        self::assertSame('https://example.com/def/air_pressure_at_sea_level', $parameter->getObservedPropertyId());
        self::assertSame('air_pressure_at_sea_level', $parameter->getObservedPropertyLabel());
        self::assertSame('Pa', $parameter->getUnit());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $data[ParameterTransformerInterface::KEY_ID] = 'airPressureAtSeaLevel';

        $parameter = (new ParameterTransformer())->transform($data);

        self::assertNull($parameter->getDescription());
        self::assertNull($parameter->getFileSuffix());
        self::assertNull($parameter->getHeight());
        self::assertNull($parameter->getObservedPropertyId());
        self::assertNull($parameter->getObservedPropertyLabel());
        self::assertNull($parameter->getUnit());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'minimal' => [[]];
        yield 'topWrongTypes' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => 42,
                ParameterTransformerInterface::KEY_DESCRIPTION => 42,
                ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => 42,
                ParameterTransformerInterface::KEY_UNIT => 42,
            ],
        ];
        yield 'emptyContainers' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [],
                ParameterTransformerInterface::KEY_DESCRIPTION => [],
                ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => [],
                ParameterTransformerInterface::KEY_UNIT => [],
            ],
        ];
        yield 'customEntriesWrongType' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [
                    ParameterTransformerInterface::KEY_FILE_SUFFIX => 42,
                    ParameterTransformerInterface::KEY_HEIGHT => 42,
                ],
            ],
        ];
        yield 'customEntriesWithoutLabel' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [
                    ParameterTransformerInterface::KEY_FILE_SUFFIX => [],
                    ParameterTransformerInterface::KEY_HEIGHT => [],
                ],
            ],
        ];
        yield 'customLabelsWrongType' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [
                    ParameterTransformerInterface::KEY_FILE_SUFFIX => [
                        ParameterTransformerInterface::KEY_LABEL => 42,
                    ],
                    ParameterTransformerInterface::KEY_HEIGHT => [
                        ParameterTransformerInterface::KEY_LABEL => 42,
                    ],
                ],
            ],
        ];
        yield 'customLabelsEmpty' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [
                    ParameterTransformerInterface::KEY_FILE_SUFFIX => [
                        ParameterTransformerInterface::KEY_LABEL => [],
                    ],
                    ParameterTransformerInterface::KEY_HEIGHT => [
                        ParameterTransformerInterface::KEY_LABEL => [],
                    ],
                ],
            ],
        ];
        yield 'customLabelsMissingEnglish' => [
            [
                ParameterTransformerInterface::KEY_CUSTOM => [
                    ParameterTransformerInterface::KEY_FILE_SUFFIX => [
                        ParameterTransformerInterface::KEY_LABEL => [
                            ParameterTransformerInterface::KEY_EN => 42,
                        ],
                    ],
                    ParameterTransformerInterface::KEY_HEIGHT => [
                        ParameterTransformerInterface::KEY_LABEL => [
                            ParameterTransformerInterface::KEY_EN => 42,
                        ],
                    ],
                ],
            ],
        ];
        yield 'innerWrongTypes' => [
            [
                ParameterTransformerInterface::KEY_DESCRIPTION => [
                    ParameterTransformerInterface::KEY_EN => 42,
                ],
                ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => [
                    ParameterTransformerInterface::KEY_ID => 42,
                    ParameterTransformerInterface::KEY_LABEL => 42,
                ],
                ParameterTransformerInterface::KEY_UNIT => [
                    ParameterTransformerInterface::KEY_SYMBOL => 42,
                ],
            ],
        ];
        yield 'deepLabelEmpty' => [
            [
                ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => [
                    ParameterTransformerInterface::KEY_LABEL => [],
                ],
            ],
        ];
        yield 'deepLabelWrongType' => [
            [
                ParameterTransformerInterface::KEY_OBSERVED_PROPERTY => [
                    ParameterTransformerInterface::KEY_LABEL => [
                        ParameterTransformerInterface::KEY_EN => 42,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ParameterTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ParameterTransformerInterface::UNEXPECTED_STRING_SPRINTF, ParameterTransformerInterface::KEY_ID));

        (new ParameterTransformer())->transform($data);
    }
}
