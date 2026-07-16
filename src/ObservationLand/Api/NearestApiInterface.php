<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

interface NearestApiInterface extends ApiInterface
{
    /**
     * @return array<int, NearestLocationInterface>
     */
    public function getByCoordinates(float $latitude, float $longitude): array;

    /**
     * @return array<int, NearestLocationInterface>
     */
    public function getByGeohash(string $geohash): array;
}
