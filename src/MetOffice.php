<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\MapImages\MapImages;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;

final class MetOffice implements MetOfficeInterface
{
    public function atmosphericModels(string $apiKey): AtmosphericModelsInterface
    {
        return new AtmosphericModels($apiKey);
    }

    public function mapImages(string $apiKey): MapImagesInterface
    {
        return new MapImages($apiKey);
    }

    public function observationLand(string $apiKey): ObservationLandInterface
    {
        return new ObservationLand($apiKey);
    }

    public function siteSpecific(string $apiKey): SiteSpecificInterface
    {
        return new SiteSpecific($apiKey);
    }
}
