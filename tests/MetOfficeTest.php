<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\MapImages\MapImages;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\MetOffice;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetOffice::class)]
#[UsesClass(AtmosphericModels::class)]
#[UsesClass(MapImages::class)]
#[UsesClass(ObservationLand::class)]
#[UsesClass(SiteSpecific::class)]
final class MetOfficeTest extends TestCase
{
    public function testAtmosphericModels(): void
    {
        $metOffice = new MetOffice();

        self::assertInstanceOf(AtmosphericModelsInterface::class, $metOffice->atmosphericModels('key'));
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
