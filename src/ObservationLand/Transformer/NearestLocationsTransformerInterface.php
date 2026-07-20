<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;

interface NearestLocationsTransformerInterface
{
    public const string ARRAY_NAME = 'locations';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, NearestLocationInterface>
     */
    public function transform(array $data): array;
}
