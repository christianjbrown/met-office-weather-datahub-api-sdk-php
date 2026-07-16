<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;

interface MetOfficeInterface
{
    public function atmosphericModels(string $apiKey): AtmosphericModelsInterface;

    public function observationLand(string $apiKey): ObservationLandInterface;

    public function siteSpecific(string $apiKey): SiteSpecificInterface;
}
