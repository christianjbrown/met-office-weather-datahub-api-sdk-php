<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsFactory;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\MapImages\MapImagesFactory;
use ChristianBrown\MetOffice\MetOffice;
use ChristianBrown\MetOffice\MetOfficeFactory;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandFactory;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetOfficeFactory::class)]
#[UsesClass(MetOffice::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(AtmosphericModelsFactory::class)]
#[UsesClass(BlendedProbForecastFactory::class)]
#[UsesClass(MapImagesFactory::class)]
#[UsesClass(ObservationLandFactory::class)]
#[UsesClass(SiteSpecificFactory::class)]
final class MetOfficeFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        self::assertInstanceOf(MetOffice::class, (new MetOfficeFactory())->create());
    }

    public function testCreateWithHost(): void
    {
        self::assertInstanceOf(MetOffice::class, (new MetOfficeFactory())->createWithHost(new ApiHost('https://sandbox.example')));
    }
}
