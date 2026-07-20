<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\Coordinates;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Coordinates::class)]
final class CoordinatesTest extends TestCase
{
    public function testGetters(): void
    {
        $coordinates = new Coordinates(51.5, -0.1);

        self::assertSame(51.5, $coordinates->getLatitude());
        self::assertSame(-0.1, $coordinates->getLongitude());
    }
}
