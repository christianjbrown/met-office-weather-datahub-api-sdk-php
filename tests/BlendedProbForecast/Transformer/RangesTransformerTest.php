<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\NdArrayInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangeTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RangesTransformer::class)]
final class RangesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            'feels_like_temperature' => ['type' => 'NdArray'],
            'screen_temperature' => ['type' => 'NdArray2'],
        ];

        $range1 = self::createStub(NdArrayInterface::class);
        $range2 = self::createStub(NdArrayInterface::class);

        $rangeTransformer = self::createStub(RangeTransformerInterface::class);
        $rangeTransformer->method('transform')
            ->willReturnMap(
                [
                    [['type' => 'NdArray', RangeTransformerInterface::KEY_ID => 'feels_like_temperature'], $range1],
                    [['type' => 'NdArray2', RangeTransformerInterface::KEY_ID => 'screen_temperature'], $range2],
                ]
            );

        $transformer = new RangesTransformer($rangeTransformer);

        self::assertSame(
            [
                'feels_like_temperature' => $range1,
                'screen_temperature' => $range2,
            ],
            $transformer->transform($data)
        );
    }

    public function testTransformEmpty(): void
    {
        $rangeTransformer = self::createStub(RangeTransformerInterface::class);

        $transformer = new RangesTransformer($rangeTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $rangeTransformer = self::createStub(RangeTransformerInterface::class);

        $transformer = new RangesTransformer($rangeTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RangesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RangesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['feels_like_temperature' => 'not-an-array']);
    }
}
