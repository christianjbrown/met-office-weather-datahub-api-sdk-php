<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Location;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
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
            LocationTransformerInterface::KEY_ID => '00099139',
            LocationTransformerInterface::KEY_GEOMETRY => [
                LocationTransformerInterface::KEY_COORDINATES => [-0.178, 51.56, 137],
            ],
        ];

        $location = (new LocationTransformer())->transform($data);

        self::assertSame(137.0, $location->getAltitude());
        self::assertSame('00099139', $location->getId());
        self::assertSame(51.56, $location->getLatitude());
        self::assertSame(-0.178, $location->getLongitude());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $location = (new LocationTransformer())->transform($data);

        self::assertNull($location->getAltitude());
        self::assertNull($location->getLatitude());
        self::assertNull($location->getLongitude());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'noGeometry' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
            ],
        ];
        yield 'geometryWrongType' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
                LocationTransformerInterface::KEY_GEOMETRY => 42,
            ],
        ];
        yield 'noCoordinates' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
                LocationTransformerInterface::KEY_GEOMETRY => [],
            ],
        ];
        yield 'coordinatesWrongType' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => 42,
                ],
            ],
        ];
        yield 'coordinatesEmpty' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => [],
                ],
            ],
        ];
        yield 'coordinatesNotNumeric' => [
            [
                LocationTransformerInterface::KEY_ID => '00099139',
                LocationTransformerInterface::KEY_GEOMETRY => [
                    LocationTransformerInterface::KEY_COORDINATES => ['a', 'b', 'c'],
                ],
            ],
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocationTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new LocationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocationTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }

    public function testTransformWithoutAltitude(): void
    {
        $data = [
            LocationTransformerInterface::KEY_ID => '00099139',
            LocationTransformerInterface::KEY_GEOMETRY => [
                LocationTransformerInterface::KEY_COORDINATES => [-0.178, 51.56],
            ],
        ];

        $location = (new LocationTransformer())->transform($data);

        self::assertNull($location->getAltitude());
        self::assertSame(51.56, $location->getLatitude());
        self::assertSame(-0.178, $location->getLongitude());
    }
}
