<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Model;

use ChristianBrown\MetOffice\AtmosphericModels\Model\AxisExtentInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\Region;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Region::class)]
final class RegionTest extends TestCase
{
    public function test(): void
    {
        $x = self::createStub(AxisExtentInterface::class);
        $y = self::createStub(AxisExtentInterface::class);

        $region = new Region();
        self::assertNull($region->getName());
        self::assertNull($region->getX());
        self::assertNull($region->getY());

        self::assertSame($region, $region->setName('Europe'));
        self::assertSame($region, $region->setX($x));
        self::assertSame($region, $region->setY($y));

        self::assertSame('Europe', $region->getName());
        self::assertSame($x, $region->getX());
        self::assertSame($y, $region->getY());
    }
}
