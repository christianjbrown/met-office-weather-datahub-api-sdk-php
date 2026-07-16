<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocation;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NearestLocation::class)]
#[CoversClass(NearestLocationTransformer::class)]
final class NearestLocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            NearestLocationTransformerInterface::KEY_GEOHASH => 'gcpvj0',
            NearestLocationTransformerInterface::KEY_AREA => 'Greater London',
            NearestLocationTransformerInterface::KEY_REGION => 'se',
            NearestLocationTransformerInterface::KEY_COUNTRY => 'England',
            NearestLocationTransformerInterface::KEY_OLSON_TIME_ZONE => 'Europe/London',
        ];

        $transformer = new NearestLocationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('gcpvj0', $actual->getGeohash());
        self::assertSame('Greater London', $actual->getArea());
        self::assertSame('se', $actual->getRegion());
        self::assertSame('England', $actual->getCountry());
        self::assertSame('Europe/London', $actual->getOlsonTimeZone());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            NearestLocationTransformerInterface::KEY_GEOHASH => 'gcpvj0',
        ];

        $transformer = new NearestLocationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('gcpvj0', $actual->getGeohash());
        self::assertNull($actual->getArea());
        self::assertNull($actual->getRegion());
        self::assertNull($actual->getCountry());
        self::assertNull($actual->getOlsonTimeZone());
    }

    /**
     * @param mixed[] $data
     */
    #[DataProvider('provideTransformSkipsOptionalFieldsCases')]
    public function testTransformSkipsOptionalFields(array $data): void
    {
        $transformer = new NearestLocationTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getArea());
        self::assertNull($actual->getRegion());
        self::assertNull($actual->getCountry());
        self::assertNull($actual->getOlsonTimeZone());
    }

    /**
     * @return iterable<string, array{mixed[]}>
     */
    public static function provideTransformSkipsOptionalFieldsCases(): iterable
    {
        yield 'absent' => [
            [
                NearestLocationTransformerInterface::KEY_GEOHASH => 'gcpvj0',
            ],
        ];
        yield 'wrongType' => [
            [
                NearestLocationTransformerInterface::KEY_GEOHASH => 'gcpvj0',
                NearestLocationTransformerInterface::KEY_AREA => 42,
                NearestLocationTransformerInterface::KEY_REGION => 42,
                NearestLocationTransformerInterface::KEY_COUNTRY => 42,
                NearestLocationTransformerInterface::KEY_OLSON_TIME_ZONE => 42,
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[NearestLocationTransformerInterface::KEY_GEOHASH => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new NearestLocationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(NearestLocationTransformerInterface::UNEXPECTED_STRING_SPRINTF, NearestLocationTransformerInterface::KEY_GEOHASH));
        $transformer->transform($data);
    }
}
