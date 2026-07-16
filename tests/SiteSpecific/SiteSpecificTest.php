<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific;

use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ThreeHourlyForecastTimeStepTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiteSpecific::class)]
#[UsesClass(HourlyForecastApi::class)]
#[UsesClass(ThreeHourlyForecastApi::class)]
#[UsesClass(DailyForecastApi::class)]
#[UsesClass(ForecastTransformer::class)]
#[UsesClass(ForecastTimeStepsTransformer::class)]
#[UsesClass(HourlyForecastTimeStepTransformer::class)]
#[UsesClass(ThreeHourlyForecastTimeStepTransformer::class)]
#[UsesClass(DailyForecastTimeStepTransformer::class)]
final class SiteSpecificTest extends TestCase
{
    public function testGetDailyForecastApi(): void
    {
        $siteSpecific = new SiteSpecific('key');

        self::assertInstanceOf(DailyForecastApi::class, $siteSpecific->getDailyForecastApi());
    }

    public function testGetHourlyForecastApi(): void
    {
        $siteSpecific = new SiteSpecific('key');

        self::assertInstanceOf(HourlyForecastApi::class, $siteSpecific->getHourlyForecastApi());
    }

    public function testGetThreeHourlyForecastApi(): void
    {
        $siteSpecific = new SiteSpecific('key');

        self::assertInstanceOf(ThreeHourlyForecastApi::class, $siteSpecific->getThreeHourlyForecastApi());
    }
}
