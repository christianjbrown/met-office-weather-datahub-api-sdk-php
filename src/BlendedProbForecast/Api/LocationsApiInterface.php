<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LocationInterface;

interface LocationsApiInterface extends ApiInterface
{
    public function getLocation(string $collectionId, string $instanceId, string $locationId, ?DataQueryInterface $query = null): CoverageCollectionInterface;

    /**
     * @return array<int, LocationInterface>
     */
    public function getLocations(string $collectionId, string $instanceId): array;
}
