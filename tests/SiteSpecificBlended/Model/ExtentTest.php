<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Extent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Extent::class)]
final class ExtentTest extends TestCase
{
    public function test(): void
    {
        $spatialBbox = [-8.0, 49.0, 2.0, 61.0];
        $temporalInterval = ['2024-03-08T00:00:00Z', '2024-03-15T00:00:00Z'];
        $temporalValues = ['2024-03-08T00:00:00Z'];
        $verticalValues = [1.5, 10.0];

        $extent = new Extent();
        self::assertSame([], $extent->getSpatialBbox());
        self::assertNull($extent->getSpatialCrs());
        self::assertSame([], $extent->getTemporalInterval());
        self::assertSame([], $extent->getTemporalValues());
        self::assertSame([], $extent->getVerticalValues());

        self::assertSame($extent, $extent->setSpatialBbox($spatialBbox));
        self::assertSame($extent, $extent->setSpatialCrs('CRS84'));
        self::assertSame($extent, $extent->setTemporalInterval($temporalInterval));
        self::assertSame($extent, $extent->setTemporalValues($temporalValues));
        self::assertSame($extent, $extent->setVerticalValues($verticalValues));

        self::assertSame($spatialBbox, $extent->getSpatialBbox());
        self::assertSame('CRS84', $extent->getSpatialCrs());
        self::assertSame($temporalInterval, $extent->getTemporalInterval());
        self::assertSame($temporalValues, $extent->getTemporalValues());
        self::assertSame($verticalValues, $extent->getVerticalValues());
    }
}
