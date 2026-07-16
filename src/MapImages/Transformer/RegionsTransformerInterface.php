<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\RegionInterface;

interface RegionsTransformerInterface
{
    public const ARRAY_NAME = 'regions';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, RegionInterface>
     */
    public function transform(array $data): array;
}
