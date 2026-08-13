<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\CoordinatesInterface;

interface PositionApiInterface extends ApiInterface
{
    public function getPosition(string $collectionId, string $instanceId, CoordinatesInterface $coordinates, ?DataQueryInterface $query = null): CoverageCollectionInterface;
}
