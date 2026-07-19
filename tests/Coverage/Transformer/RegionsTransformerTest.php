<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RegionInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RegionsTransformer::class)]
final class RegionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-region-1'], ['test-region-2']];

        $region1 = self::createStub(RegionInterface::class);
        $region2 = self::createStub(RegionInterface::class);
        $regions = [$region1, $region2];

        $regionTransformer = self::createStub(RegionTransformerInterface::class);
        $regionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-region-1'], $region1],
                    [['test-region-2'], $region2],
                ]
            );

        $transformer = new RegionsTransformer($regionTransformer);

        self::assertSame($regions, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $regionTransformer = self::createStub(RegionTransformerInterface::class);

        $transformer = new RegionsTransformer($regionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $region1 = self::createStub(RegionInterface::class);

        $regionTransformer = self::createMock(RegionTransformerInterface::class);
        $regionTransformer->method('transform')
            ->with(['test-region-1'])
            ->willReturn($region1);

        $transformer = new RegionsTransformer($regionTransformer);

        self::assertSame([$region1], $transformer->transform([['test-region-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $regionTransformer = self::createStub(RegionTransformerInterface::class);

        $transformer = new RegionsTransformer($regionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RegionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RegionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-region-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-region-1-array'], 'test-region-2-not-array', ['test-region-3-array'], 'test-region-4-not-array'];

        $region1 = self::createStub(RegionInterface::class);
        $region3 = self::createStub(RegionInterface::class);

        $regionTransformer = self::createStub(RegionTransformerInterface::class);
        $regionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-region-1-array'], $region1],
                    [['test-region-3-array'], $region3],
                ]
            );

        $transformer = new RegionsTransformer($regionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RegionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RegionsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
