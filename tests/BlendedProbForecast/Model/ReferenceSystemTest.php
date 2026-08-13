<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReferenceSystem::class)]
final class ReferenceSystemTest extends TestCase
{
    public function test(): void
    {
        $coordinates = ['percentiles'];
        $identifiers = ['5' => '5th percentile', '95' => '95th percentile'];

        $referenceSystem = new ReferenceSystem($coordinates);
        self::assertNull($referenceSystem->getCalendar());
        self::assertSame($coordinates, $referenceSystem->getCoordinates());
        self::assertNull($referenceSystem->getId());
        self::assertSame([], $referenceSystem->getIdentifiers());
        self::assertNull($referenceSystem->getLabel());
        self::assertNull($referenceSystem->getType());

        self::assertSame($referenceSystem, $referenceSystem->setCalendar('Gregorian'));
        self::assertSame($referenceSystem, $referenceSystem->setCoordinates(['t']));
        self::assertSame($referenceSystem, $referenceSystem->setId('https://www.opengis.net/def/crs/EPSG/0/4979'));
        self::assertSame($referenceSystem, $referenceSystem->setIdentifiers($identifiers));
        self::assertSame($referenceSystem, $referenceSystem->setLabel('percentiles'));
        self::assertSame($referenceSystem, $referenceSystem->setType('IdentifierRS'));

        self::assertSame('Gregorian', $referenceSystem->getCalendar());
        self::assertSame(['t'], $referenceSystem->getCoordinates());
        self::assertSame('https://www.opengis.net/def/crs/EPSG/0/4979', $referenceSystem->getId());
        self::assertSame($identifiers, $referenceSystem->getIdentifiers());
        self::assertSame('percentiles', $referenceSystem->getLabel());
        self::assertSame('IdentifierRS', $referenceSystem->getType());
    }
}
