<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;

final class BlendedProbForecast implements BlendedProbForecastInterface
{
    private CapabilitiesApiInterface $capabilitiesApi;
    private CollectionsApiInterface $collectionsApi;
    private InstancesApiInterface $instancesApi;
    private LocationsApiInterface $locationsApi;
    private PositionApiInterface $positionApi;

    public function __construct(
        CapabilitiesApiInterface $capabilitiesApi,
        CollectionsApiInterface $collectionsApi,
        InstancesApiInterface $instancesApi,
        LocationsApiInterface $locationsApi,
        PositionApiInterface $positionApi
    ) {
        $this->capabilitiesApi = $capabilitiesApi;
        $this->collectionsApi = $collectionsApi;
        $this->instancesApi = $instancesApi;
        $this->locationsApi = $locationsApi;
        $this->positionApi = $positionApi;
    }

    public function getCapabilitiesApi(): CapabilitiesApiInterface
    {
        return $this->capabilitiesApi;
    }

    public function getCollectionsApi(): CollectionsApiInterface
    {
        return $this->collectionsApi;
    }

    public function getInstancesApi(): InstancesApiInterface
    {
        return $this->instancesApi;
    }

    public function getLocationsApi(): LocationsApiInterface
    {
        return $this->locationsApi;
    }

    public function getPositionApi(): PositionApiInterface
    {
        return $this->positionApi;
    }
}
