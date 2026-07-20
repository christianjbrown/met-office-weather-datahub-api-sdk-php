<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformerInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NearestLocationsTransformer::class)]
final class NearestLocationsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-location-1'], ['test-location-2']];

        $location1 = self::createStub(NearestLocationInterface::class);
        $location2 = self::createStub(NearestLocationInterface::class);
        $locations = [$location1, $location2];

        $locationTransformer = self::createStub(NearestLocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-location-1'], $location1],
                    [['test-location-2'], $location2],
                ]
            );

        $transformer = new NearestLocationsTransformer($locationTransformer);

        self::assertSame($locations, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $locationTransformer = self::createStub(NearestLocationTransformerInterface::class);

        $transformer = new NearestLocationsTransformer($locationTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $location1 = self::createStub(NearestLocationInterface::class);

        $locationTransformer = self::createMock(NearestLocationTransformerInterface::class);
        $locationTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-location-1'])
            ->willReturn($location1);

        $transformer = new NearestLocationsTransformer($locationTransformer);

        self::assertSame([$location1], $transformer->transform([['test-location-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $locationTransformer = self::createStub(NearestLocationTransformerInterface::class);

        $transformer = new NearestLocationsTransformer($locationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(NearestLocationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, NearestLocationsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-location-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-location-1-array'], 'test-location-2-not-array', ['test-location-3-array'], 'test-location-4-not-array'];

        $location1 = self::createStub(NearestLocationInterface::class);
        $location3 = self::createStub(NearestLocationInterface::class);

        $locationTransformer = self::createStub(NearestLocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-location-1-array'], $location1],
                    [['test-location-3-array'], $location3],
                ]
            );

        $transformer = new NearestLocationsTransformer($locationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(NearestLocationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, NearestLocationsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
