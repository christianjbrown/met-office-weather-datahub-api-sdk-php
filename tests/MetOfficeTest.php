<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\Api\DailyForecastApi;
use ChristianBrown\MetOffice\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\MetOffice;
use ChristianBrown\MetOffice\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\ThreeHourlyForecastTimeStepTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetOffice::class)]
#[UsesClass(HourlyForecastApi::class)]
#[UsesClass(ThreeHourlyForecastApi::class)]
#[UsesClass(DailyForecastApi::class)]
#[UsesClass(ForecastTransformer::class)]
#[UsesClass(ForecastTimeStepsTransformer::class)]
#[UsesClass(HourlyForecastTimeStepTransformer::class)]
#[UsesClass(ThreeHourlyForecastTimeStepTransformer::class)]
#[UsesClass(DailyForecastTimeStepTransformer::class)]
final class MetOfficeTest extends TestCase
{
    public function testGetDailyForecastApi(): void
    {
        $metOffice = new MetOffice('key');

        self::assertInstanceOf(DailyForecastApi::class, $metOffice->getDailyForecastApi());
    }

    public function testGetHourlyForecastApi(): void
    {
        $metOffice = new MetOffice('key');

        self::assertInstanceOf(HourlyForecastApi::class, $metOffice->getHourlyForecastApi());
    }

    public function testGetThreeHourlyForecastApi(): void
    {
        $metOffice = new MetOffice('key');

        self::assertInstanceOf(ThreeHourlyForecastApi::class, $metOffice->getThreeHourlyForecastApi());
    }
}
