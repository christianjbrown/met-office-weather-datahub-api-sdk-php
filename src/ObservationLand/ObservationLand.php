<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand;

use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;

final class ObservationLand implements ObservationLandInterface
{
    private NearestApiInterface $nearestApi;
    private ObservationApiInterface $observationApi;

    public function __construct(
        NearestApiInterface $nearestApi,
        ObservationApiInterface $observationApi
    ) {
        $this->nearestApi = $nearestApi;
        $this->observationApi = $observationApi;
    }

    public function getNearestApi(): NearestApiInterface
    {
        return $this->nearestApi;
    }

    public function getObservationApi(): ObservationApiInterface
    {
        return $this->observationApi;
    }
}
