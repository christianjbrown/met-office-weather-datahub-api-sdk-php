<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\MetOffice\CoordinatesInterface;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

interface NearestApiInterface extends ApiInterface
{
    /**
     * @return array<int, NearestLocationInterface>
     */
    public function getByCoordinates(CoordinatesInterface $coordinates): array;

    /**
     * @return array<int, NearestLocationInterface>
     */
    public function getByGeohash(string $geohash): array;
}
