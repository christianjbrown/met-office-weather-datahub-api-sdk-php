<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsFactory;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesFactory;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandFactory;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactory;

/**
 * Composition root for the SDK entry point.
 */
final class MetOfficeFactory implements MetOfficeFactoryInterface
{
    public function create(): MetOfficeInterface
    {
        return $this->createWithHost(new ApiHost());
    }

    public function createWithHost(ApiHostInterface $apiHost): MetOfficeInterface
    {
        return new MetOffice(
            $apiHost,
            new AtmosphericModelsFactory(),
            new BlendedProbForecastFactory(),
            new MapImagesFactory(),
            new ObservationLandFactory(),
            new SiteSpecificFactory(),
        );
    }
}
