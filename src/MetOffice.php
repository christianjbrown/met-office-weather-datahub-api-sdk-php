<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsFactoryInterface;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastFactoryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesFactoryInterface;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandFactoryInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificFactoryInterface;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;

final class MetOffice implements MetOfficeInterface
{
    private ApiHostInterface $apiHost;
    private AtmosphericModelsFactoryInterface $atmosphericModelsFactory;
    private BlendedProbForecastFactoryInterface $blendedProbForecastFactory;
    private MapImagesFactoryInterface $mapImagesFactory;
    private ObservationLandFactoryInterface $observationLandFactory;
    private SiteSpecificFactoryInterface $siteSpecificFactory;

    public function __construct(
        ApiHostInterface $apiHost,
        AtmosphericModelsFactoryInterface $atmosphericModelsFactory,
        BlendedProbForecastFactoryInterface $blendedProbForecastFactory,
        MapImagesFactoryInterface $mapImagesFactory,
        ObservationLandFactoryInterface $observationLandFactory,
        SiteSpecificFactoryInterface $siteSpecificFactory
    ) {
        $this->apiHost = $apiHost;
        $this->atmosphericModelsFactory = $atmosphericModelsFactory;
        $this->blendedProbForecastFactory = $blendedProbForecastFactory;
        $this->mapImagesFactory = $mapImagesFactory;
        $this->observationLandFactory = $observationLandFactory;
        $this->siteSpecificFactory = $siteSpecificFactory;
    }

    public function atmosphericModels(string $apiKey): AtmosphericModelsInterface
    {
        return $this->atmosphericModelsFactory->create($apiKey, $this->apiHost);
    }

    public function blendedProbForecast(string $apiKey): BlendedProbForecastInterface
    {
        return $this->blendedProbForecastFactory->create($apiKey, $this->apiHost);
    }

    public function mapImages(string $apiKey): MapImagesInterface
    {
        return $this->mapImagesFactory->create($apiKey, $this->apiHost);
    }

    public function observationLand(string $apiKey): ObservationLandInterface
    {
        return $this->observationLandFactory->create($apiKey, $this->apiHost);
    }

    public function siteSpecific(string $apiKey): SiteSpecificInterface
    {
        return $this->siteSpecificFactory->create($apiKey, $this->apiHost);
    }
}
