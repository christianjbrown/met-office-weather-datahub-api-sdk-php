<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Location;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Location::class)]
#[CoversClass(LocationTransformer::class)]
final class LocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LocationTransformerInterface::KEY_ID => '3005',
            LocationTransformerInterface::KEY_GEOMETRY => [
                LocationTransformerInterface::KEY_COORDINATES => [-1, 60.13],
            ],
            LocationTransformerInterface::KEY_PROPERTIES => [
                LocationTransformerInterface::KEY_NAME => 'Lerwick',
            ],
        ];

        $location = (new LocationTransformer())->transform($data);

        self::assertSame('3005', $location->getId());
        self::assertSame(-1.0, $location->getLongitude());
        self::assertSame(60.13, $location->getLatitude());
        self::assertSame('Lerwick', $location->getName());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            LocationTransformerInterface::KEY_ID => '3005',
        ];

        $location = (new LocationTransformer())->transform($data);

        self::assertSame('3005', $location->getId());
        self::assertNull($location->getLongitude());
        self::assertNull($location->getLatitude());
        self::assertNull($location->getName());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $location = (new LocationTransformer())->transform($data);

        self::assertNull($location->getLongitude());
        self::assertNull($location->getLatitude());
        self::assertNull($location->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'topLevelWrongTypes' => [
            [
                LocationTransformerInterface::KEY_ID => '3005',
                LocationTransformerInterface::KEY_GEOMETRY => 42,
                LocationTransformerInterface::KEY_PROPERTIES => 42,
            ],
        ];
        yield 'emptyContainers' => [
            [
                LocationTransformerInterface::KEY_ID => '3005',
                LocationTransformerInterface::KEY_GEOMETRY => [],
                LocationTransformerInterface::KEY_PROPERTIES => [],
            ],
        ];
        yield 'coordinatesWrongType' => [
            [
                LocationTransformerInterface::KEY_ID => '3005',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => 42,
                ],
                LocationTransformerInterface::KEY_PROPERTIES => [
                    LocationTransformerInterface::KEY_NAME => 42,
                ],
            ],
        ];
        yield 'coordinatesMissing' => [
            [
                LocationTransformerInterface::KEY_ID => '3005',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => [],
                ],
            ],
        ];
        yield 'coordinatesNonNumeric' => [
            [
                LocationTransformerInterface::KEY_ID => '3005',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => ['x', 'y'],
                ],
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocationTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocationTransformerInterface::KEY_ID));

        (new LocationTransformer())->transform($data);
    }
}
