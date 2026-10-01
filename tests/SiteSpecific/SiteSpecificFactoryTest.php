<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Container\DailyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\HourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\ThreeHourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactory;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformerFactory;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\AtmosphereFieldApplierProvider;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\DayFieldApplierProvider;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\FloatFieldApplier;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\IntFieldApplier;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\NightFieldApplierProvider;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\WeatherTypeFieldApplier;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ThreeHourlyForecastTimeStepTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiteSpecificFactory::class)]
#[UsesClass(SiteSpecific::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(RegistrarContainerFactory::class)]
#[UsesClass(HourlyForecastRegistrar::class)]
#[UsesClass(ThreeHourlyForecastRegistrar::class)]
#[UsesClass(DailyForecastRegistrar::class)]
#[UsesClass(HourlyForecastApi::class)]
#[UsesClass(ForecastApi::class)]
#[UsesClass(ThreeHourlyForecastApi::class)]
#[UsesClass(DailyForecastApi::class)]
#[UsesClass(ForecastTransformer::class)]
#[UsesClass(ForecastTimeStepsTransformer::class)]
#[UsesClass(HourlyForecastTimeStepTransformer::class)]
#[UsesClass(ThreeHourlyForecastTimeStepTransformer::class)]
#[UsesClass(DailyForecastTimeStepTransformer::class)]
#[UsesClass(DailyForecastTimeStepTransformerFactory::class)]
#[UsesClass(AtmosphereFieldApplierProvider::class)]
#[UsesClass(DayFieldApplierProvider::class)]
#[UsesClass(NightFieldApplierProvider::class)]
#[UsesClass(FloatFieldApplier::class)]
#[UsesClass(IntFieldApplier::class)]
#[UsesClass(WeatherTypeFieldApplier::class)]
final class SiteSpecificFactoryTest extends TestCase
{
    public function testGetDailyForecastApi(): void
    {
        $siteSpecific = (new SiteSpecificFactory())->create('key', new ApiHost());

        self::assertInstanceOf(DailyForecastApi::class, $siteSpecific->getDailyForecastApi());
    }

    public function testGetHourlyForecastApi(): void
    {
        $siteSpecific = (new SiteSpecificFactory())->create('key', new ApiHost());

        self::assertInstanceOf(HourlyForecastApi::class, $siteSpecific->getHourlyForecastApi());
    }

    public function testGetThreeHourlyForecastApi(): void
    {
        $siteSpecific = (new SiteSpecificFactory())->create('key', new ApiHost());

        self::assertInstanceOf(ThreeHourlyForecastApi::class, $siteSpecific->getThreeHourlyForecastApi());
    }
}
