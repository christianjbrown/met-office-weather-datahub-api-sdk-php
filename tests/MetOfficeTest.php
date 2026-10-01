<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsFactoryInterface;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastFactoryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesFactoryInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\MetOffice;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandFactoryInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactoryInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetOffice::class)]
final class MetOfficeTest extends TestCase
{
    public function testEachProductIsBuiltByItsFactoryWithTheHost(): void
    {
        $host = self::createStub(ApiHostInterface::class);
        $atmosphericModels = self::createStub(AtmosphericModelsInterface::class);
        $blendedProbForecast = self::createStub(BlendedProbForecastInterface::class);
        $mapImages = self::createStub(MapImagesInterface::class);
        $observationLand = self::createStub(ObservationLandInterface::class);
        $siteSpecific = self::createStub(SiteSpecificInterface::class);

        $atmosphericModelsFactory = $this->createMock(AtmosphericModelsFactoryInterface::class);
        $atmosphericModelsFactory->expects(self::once())->method('create')->with('key', $host)->willReturn($atmosphericModels);
        $blendedProbForecastFactory = $this->createMock(BlendedProbForecastFactoryInterface::class);
        $blendedProbForecastFactory->expects(self::once())->method('create')->with('key', $host)->willReturn($blendedProbForecast);
        $mapImagesFactory = $this->createMock(MapImagesFactoryInterface::class);
        $mapImagesFactory->expects(self::once())->method('create')->with('key', $host)->willReturn($mapImages);
        $observationLandFactory = $this->createMock(ObservationLandFactoryInterface::class);
        $observationLandFactory->expects(self::once())->method('create')->with('key', $host)->willReturn($observationLand);
        $siteSpecificFactory = $this->createMock(SiteSpecificFactoryInterface::class);
        $siteSpecificFactory->expects(self::once())->method('create')->with('key', $host)->willReturn($siteSpecific);

        $metOffice = new MetOffice(
            $host,
            $atmosphericModelsFactory,
            $blendedProbForecastFactory,
            $mapImagesFactory,
            $observationLandFactory,
            $siteSpecificFactory
        );

        self::assertSame($atmosphericModels, $metOffice->atmosphericModels('key'));
        self::assertSame($blendedProbForecast, $metOffice->blendedProbForecast('key'));
        self::assertSame($mapImages, $metOffice->mapImages('key'));
        self::assertSame($observationLand, $metOffice->observationLand('key'));
        self::assertSame($siteSpecific, $metOffice->siteSpecific('key'));
    }
}
