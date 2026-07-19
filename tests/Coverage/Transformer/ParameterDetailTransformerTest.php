<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\ParameterDetail;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ParameterDetail::class)]
#[CoversClass(ParameterDetailTransformer::class)]
final class ParameterDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 'temperature',
            ParameterDetailTransformerInterface::KEY_EXTENT => [
                ParameterDetailTransformerInterface::KEY_TIME => ['2020-02-19T12:00:00.000Z', 42],
                ParameterDetailTransformerInterface::KEY_VERTICAL => [100000, 1.5, 'not-a-number'],
            ],
        ];

        $transformer = new ParameterDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('temperature', $actual->getParameterId());
        self::assertSame(['2020-02-19T12:00:00.000Z'], $actual->getTimeCoordinates());
        self::assertSame([100000.0, 1.5], $actual->getVerticalCoordinates());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 'temperature',
        ];

        $transformer = new ParameterDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('temperature', $actual->getParameterId());
        self::assertSame([], $actual->getTimeCoordinates());
        self::assertSame([], $actual->getVerticalCoordinates());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCoordinatesCases')]
    public function testTransformSkipsCoordinates(array $data): void
    {
        $transformer = new ParameterDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([], $actual->getTimeCoordinates());
        self::assertSame([], $actual->getVerticalCoordinates());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCoordinatesCases(): iterable
    {
        yield 'extentWrongType' => [
            [
                ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 'temperature',
                ParameterDetailTransformerInterface::KEY_EXTENT => 'not-an-array',
            ],
        ];
        yield 'axesAbsent' => [
            [
                ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 'temperature',
                ParameterDetailTransformerInterface::KEY_EXTENT => ['filler' => 1],
            ],
        ];
        yield 'axesWrongType' => [
            [
                ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 'temperature',
                ParameterDetailTransformerInterface::KEY_EXTENT => [
                    ParameterDetailTransformerInterface::KEY_TIME => 'not-an-array',
                    ParameterDetailTransformerInterface::KEY_VERTICAL => 'not-an-array',
                ],
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ParameterDetailTransformerInterface::KEY_PARAMETER_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ParameterDetailTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ParameterDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, ParameterDetailTransformerInterface::KEY_PARAMETER_ID));
        $transformer->transform($data);
    }
}
