<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Location;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Location::class)]
final class LocationTest extends TestCase
{
    public function test(): void
    {
        $location = new Location('3005');
        self::assertSame('3005', $location->getId());
        self::assertNull($location->getLatitude());
        self::assertNull($location->getLongitude());
        self::assertNull($location->getName());

        self::assertSame($location, $location->setId('3002'));
        self::assertSame($location, $location->setLatitude(60.13));
        self::assertSame($location, $location->setLongitude(-1.18));
        self::assertSame($location, $location->setName('Lerwick'));

        self::assertSame('3002', $location->getId());
        self::assertSame(60.13, $location->getLatitude());
        self::assertSame(-1.18, $location->getLongitude());
        self::assertSame('Lerwick', $location->getName());
    }
}
