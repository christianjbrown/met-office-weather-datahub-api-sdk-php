<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RegionInterface;

interface RegionTransformerInterface
{
    public const KEY_EXTENT = 'extent';
    public const KEY_NAME = 'name';
    public const KEY_X = 'x';
    public const KEY_Y = 'y';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RegionInterface;
}
