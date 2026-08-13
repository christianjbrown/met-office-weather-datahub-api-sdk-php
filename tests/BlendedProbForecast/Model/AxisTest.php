<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Axis;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Axis::class)]
final class AxisTest extends TestCase
{
    public function test(): void
    {
        $bounds = ['2026-08-12T12:00:00Z', '2026-08-13T00:00:00Z'];
        $floatValues = [-0.178, 51.56];
        $stringValues = ['2026-08-13T00:00:00Z'];

        $axis = new Axis('t');
        self::assertSame([], $axis->getBounds());
        self::assertSame([], $axis->getFloatValues());
        self::assertSame('t', $axis->getName());
        self::assertSame([], $axis->getStringValues());

        self::assertSame($axis, $axis->setBounds($bounds));
        self::assertSame($axis, $axis->setFloatValues($floatValues));
        self::assertSame($axis, $axis->setName('percentiles'));
        self::assertSame($axis, $axis->setStringValues($stringValues));

        self::assertSame($bounds, $axis->getBounds());
        self::assertSame($floatValues, $axis->getFloatValues());
        self::assertSame('percentiles', $axis->getName());
        self::assertSame($stringValues, $axis->getStringValues());
    }
}
