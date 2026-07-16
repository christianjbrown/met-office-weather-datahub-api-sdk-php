<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Model;

use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NearestLocation::class)]
final class NearestLocationTest extends TestCase
{
    public function test(): void
    {
        $location = new NearestLocation('gcpvj0');
        self::assertSame('gcpvj0', $location->getGeohash());
        self::assertNull($location->getArea());
        self::assertNull($location->getRegion());
        self::assertNull($location->getCountry());
        self::assertNull($location->getOlsonTimeZone());

        self::assertSame($location, $location->setGeohash('u10hb3'));
        self::assertSame($location, $location->setArea('Greater London'));
        self::assertSame($location, $location->setRegion('se'));
        self::assertSame($location, $location->setCountry('England'));
        self::assertSame($location, $location->setOlsonTimeZone('Europe/London'));

        self::assertSame('u10hb3', $location->getGeohash());
        self::assertSame('Greater London', $location->getArea());
        self::assertSame('se', $location->getRegion());
        self::assertSame('England', $location->getCountry());
        self::assertSame('Europe/London', $location->getOlsonTimeZone());
    }
}
