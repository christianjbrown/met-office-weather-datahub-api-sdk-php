<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Enums;

use ChristianBrown\MetOffice\Enums\WeatherType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(WeatherType::class)]
final class WeatherTypeTest extends TestCase
{
    #[TestWith([-1, WeatherType::TRACE_RAIN])]
    #[TestWith([0, WeatherType::CLEAR_NIGHT])]
    #[TestWith([1, WeatherType::SUNNY_DAY])]
    #[TestWith([30, WeatherType::THUNDER])]
    public function testFrom(int $value, WeatherType $expected): void
    {
        self::assertSame($expected, WeatherType::from($value));
    }

    #[TestWith([99])]
    #[TestWith([100])]
    public function testTryFromUnknownReturnsNull(int $value): void
    {
        self::assertNull(WeatherType::tryFrom($value));
    }
}
