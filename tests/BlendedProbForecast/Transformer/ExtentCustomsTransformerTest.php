<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExtentCustomsTransformer::class)]
final class ExtentCustomsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['custom-1'], ['custom-2']];

        $custom1 = self::createStub(ExtentCustomInterface::class);
        $custom2 = self::createStub(ExtentCustomInterface::class);

        $extentCustomTransformer = self::createStub(ExtentCustomTransformerInterface::class);
        $extentCustomTransformer->method('transform')
            ->willReturnMap(
                [
                    [['custom-1'], $custom1],
                    [['custom-2'], $custom2],
                ]
            );

        $transformer = new ExtentCustomsTransformer($extentCustomTransformer);

        self::assertSame([$custom1, $custom2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $extentCustomTransformer = self::createStub(ExtentCustomTransformerInterface::class);

        $transformer = new ExtentCustomsTransformer($extentCustomTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $extentCustomTransformer = self::createStub(ExtentCustomTransformerInterface::class);

        $transformer = new ExtentCustomsTransformer($extentCustomTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ExtentCustomsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ExtentCustomsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
