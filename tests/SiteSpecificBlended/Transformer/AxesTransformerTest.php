<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\AxisInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxesTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxisTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AxesTransformer::class)]
final class AxesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            't' => ['values' => ['2024-03-08T00:00:00Z']],
            'x' => ['values' => [50.1643]],
        ];

        $tAxis = self::createStub(AxisInterface::class);
        $xAxis = self::createStub(AxisInterface::class);

        $axisTransformer = self::createStub(AxisTransformerInterface::class);
        $axisTransformer->method('transform')
            ->willReturnMap(
                [
                    [['values' => ['2024-03-08T00:00:00Z'], AxisTransformerInterface::KEY_NAME => 't'], $tAxis],
                    [['values' => [50.1643], AxisTransformerInterface::KEY_NAME => 'x'], $xAxis],
                ]
            );

        $transformer = new AxesTransformer($axisTransformer);

        self::assertSame(['t' => $tAxis, 'x' => $xAxis], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $axisTransformer = self::createStub(AxisTransformerInterface::class);

        $transformer = new AxesTransformer($axisTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $axisTransformer = self::createStub(AxisTransformerInterface::class);

        $transformer = new AxesTransformer($axisTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AxesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AxesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['t' => 'not-an-array']);
    }
}
