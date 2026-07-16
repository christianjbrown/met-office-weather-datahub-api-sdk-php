<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Api;

use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;

interface ObservationApiInterface extends ApiInterface
{
    /**
     * @return array<int, ObservationInterface>
     */
    public function getByGeohash(string $geohash, bool $skipCache = false): array;
}
