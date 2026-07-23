<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\SiteSpecificBlendedInterface;

interface MetOfficeInterface
{
    public function atmosphericModels(string $apiKey): AtmosphericModelsInterface;

    public function mapImages(string $apiKey): MapImagesInterface;

    public function observationLand(string $apiKey): ObservationLandInterface;

    public function siteSpecific(string $apiKey): SiteSpecificInterface;

    public function siteSpecificBlended(string $apiKey): SiteSpecificBlendedInterface;
}
