<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Container\OrdersApiRegistrar as AtmosphericModelsOrdersApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\RunsApiRegistrar as AtmosphericModelsRunsApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\TransformersRegistrar as AtmosphericModelsTransformersRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecast;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CapabilitiesApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CollectionsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CoverageTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ExtentTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\InstancesApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LinksTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LocationsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\PositionApiRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\MapImages\Container\OrdersApiRegistrar as MapImagesOrdersApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\RunsApiRegistrar as MapImagesRunsApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\TransformersRegistrar as MapImagesTransformersRegistrar;
use ChristianBrown\MetOffice\MapImages\MapImages;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\MetOffice;
use ChristianBrown\MetOffice\ObservationLand\Container\NearestApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\Container\ObservationApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\Container\DailyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\HourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\ThreeHourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetOffice::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(RawRequestSenderRegistrar::class)]
#[UsesClass(RegistrarContainerFactory::class)]
#[UsesClass(AtmosphericModels::class)]
#[UsesClass(AtmosphericModelsTransformersRegistrar::class)]
#[UsesClass(AtmosphericModelsRunsApiRegistrar::class)]
#[UsesClass(AtmosphericModelsOrdersApiRegistrar::class)]
#[UsesClass(MapImages::class)]
#[UsesClass(MapImagesTransformersRegistrar::class)]
#[UsesClass(MapImagesRunsApiRegistrar::class)]
#[UsesClass(MapImagesOrdersApiRegistrar::class)]
#[UsesClass(ObservationLand::class)]
#[UsesClass(NearestApiRegistrar::class)]
#[UsesClass(ObservationApiRegistrar::class)]
#[UsesClass(SiteSpecific::class)]
#[UsesClass(HourlyForecastRegistrar::class)]
#[UsesClass(ThreeHourlyForecastRegistrar::class)]
#[UsesClass(DailyForecastRegistrar::class)]
#[UsesClass(BlendedProbForecast::class)]
#[UsesClass(LinksTransformerRegistrar::class)]
#[UsesClass(ExtentTransformerRegistrar::class)]
#[UsesClass(ParametersTransformerRegistrar::class)]
#[UsesClass(CoverageTransformerRegistrar::class)]
#[UsesClass(CapabilitiesApiRegistrar::class)]
#[UsesClass(CollectionsApiRegistrar::class)]
#[UsesClass(InstancesApiRegistrar::class)]
#[UsesClass(LocationsApiRegistrar::class)]
#[UsesClass(PositionApiRegistrar::class)]
final class MetOfficeTest extends TestCase
{
    public function testAtmosphericModels(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(AtmosphericModelsInterface::class, $metOffice->atmosphericModels('key'));
    }

    public function testBlendedProbForecast(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(BlendedProbForecastInterface::class, $metOffice->blendedProbForecast('key'));
    }

    public function testMapImages(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(MapImagesInterface::class, $metOffice->mapImages('key'));
    }

    public function testObservationLand(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(ObservationLandInterface::class, $metOffice->observationLand('key'));
    }

    public function testSiteSpecific(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(SiteSpecificInterface::class, $metOffice->siteSpecific('key'));
    }
}
