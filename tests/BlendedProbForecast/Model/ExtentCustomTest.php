<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustom;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExtentCustom::class)]
final class ExtentCustomTest extends TestCase
{
    public function test(): void
    {
        $interval = ['5', '95'];
        $values = ['5', '50', '95'];

        $extentCustom = new ExtentCustom('percentile');
        self::assertSame('percentile', $extentCustom->getId());
        self::assertSame([], $extentCustom->getInterval());
        self::assertNull($extentCustom->getReference());
        self::assertSame([], $extentCustom->getValues());

        self::assertSame($extentCustom, $extentCustom->setId('threshold'));
        self::assertSame($extentCustom, $extentCustom->setInterval($interval));
        self::assertSame($extentCustom, $extentCustom->setReference('percentile'));
        self::assertSame($extentCustom, $extentCustom->setValues($values));

        self::assertSame('threshold', $extentCustom->getId());
        self::assertSame($interval, $extentCustom->getInterval());
        self::assertSame('percentile', $extentCustom->getReference());
        self::assertSame($values, $extentCustom->getValues());
    }
}
