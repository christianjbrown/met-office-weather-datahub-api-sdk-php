<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific;

use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiteSpecific::class)]
final class SiteSpecificTest extends TestCase
{
    public function testReturnsInjectedApis(): void
    {
        $dailyForecastApi = self::createStub(DailyForecastApiInterface::class);
        $hourlyForecastApi = self::createStub(HourlyForecastApiInterface::class);
        $threeHourlyForecastApi = self::createStub(ThreeHourlyForecastApiInterface::class);
        $facade = new SiteSpecific($dailyForecastApi, $hourlyForecastApi, $threeHourlyForecastApi);

        self::assertSame($dailyForecastApi, $facade->getDailyForecastApi());
        self::assertSame($hourlyForecastApi, $facade->getHourlyForecastApi());
        self::assertSame($threeHourlyForecastApi, $facade->getThreeHourlyForecastApi());
    }
}
