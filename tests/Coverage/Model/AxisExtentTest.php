<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Model;

use ChristianBrown\MetOffice\Coverage\Model\AxisExtent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AxisExtent::class)]
final class AxisExtentTest extends TestCase
{
    public function test(): void
    {
        $axisExtent = new AxisExtent();
        self::assertNull($axisExtent->getLabel());
        self::assertNull($axisExtent->getLowerBound());
        self::assertNull($axisExtent->getUomLabel());
        self::assertNull($axisExtent->getUpperBound());

        self::assertSame($axisExtent, $axisExtent->setLabel('longitude'));
        self::assertSame($axisExtent, $axisExtent->setLowerBound('-14.0000'));
        self::assertSame($axisExtent, $axisExtent->setUomLabel('degree'));
        self::assertSame($axisExtent, $axisExtent->setUpperBound('37.0000'));

        self::assertSame('longitude', $axisExtent->getLabel());
        self::assertSame('-14.0000', $axisExtent->getLowerBound());
        self::assertSame('degree', $axisExtent->getUomLabel());
        self::assertSame('37.0000', $axisExtent->getUpperBound());
    }
}
