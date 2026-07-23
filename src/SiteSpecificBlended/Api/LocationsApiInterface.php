<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;

interface LocationsApiInterface extends ApiInterface
{
    public function getCoverage(string $collectionId, string $locationId, ?string $parameterName = null, ?string $datetime = null): CoverageCollectionInterface;

    /**
     * @return array<int, LocationInterface>
     */
    public function getLocations(string $collectionId): array;
}
