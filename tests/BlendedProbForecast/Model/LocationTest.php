<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Location;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Location::class)]
final class LocationTest extends TestCase
{
    public function test(): void
    {
        $location = new Location('00099139');
        self::assertNull($location->getAltitude());
        self::assertSame('00099139', $location->getId());
        self::assertNull($location->getLatitude());
        self::assertNull($location->getLongitude());

        self::assertSame($location, $location->setAltitude(137.0));
        self::assertSame($location, $location->setId('00000046'));
        self::assertSame($location, $location->setLatitude(51.56));
        self::assertSame($location, $location->setLongitude(-0.178));

        self::assertSame(137.0, $location->getAltitude());
        self::assertSame('00000046', $location->getId());
        self::assertSame(51.56, $location->getLatitude());
        self::assertSame(-0.178, $location->getLongitude());
    }
}
