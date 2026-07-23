<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Axis;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Axis::class)]
final class AxisTest extends TestCase
{
    public function test(): void
    {
        $floatValues = [50.1643];
        $stringValues = ['5', '10', '15'];

        $axis = new Axis('percentiles');
        self::assertSame('percentiles', $axis->getName());
        self::assertSame([], $axis->getFloatValues());
        self::assertSame([], $axis->getStringValues());

        self::assertSame($axis, $axis->setFloatValues($floatValues));
        self::assertSame($axis, $axis->setName('t'));
        self::assertSame($axis, $axis->setStringValues($stringValues));

        self::assertSame($floatValues, $axis->getFloatValues());
        self::assertSame('t', $axis->getName());
        self::assertSame($stringValues, $axis->getStringValues());
    }
}
