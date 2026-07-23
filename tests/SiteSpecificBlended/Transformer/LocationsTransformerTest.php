<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocationsTransformer::class)]
final class LocationsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['location-1'], ['location-2']];

        $location1 = self::createStub(LocationInterface::class);
        $location2 = self::createStub(LocationInterface::class);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['location-1'], $location1],
                    [['location-2'], $location2],
                ]
            );

        $transformer = new LocationsTransformer($locationTransformer);

        self::assertSame([$location1, $location2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $transformer = new LocationsTransformer($locationTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $transformer = new LocationsTransformer($locationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocationsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
