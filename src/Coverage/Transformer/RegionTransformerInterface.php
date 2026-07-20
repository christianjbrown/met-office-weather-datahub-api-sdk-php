<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RegionInterface;

interface RegionTransformerInterface
{
    public const string KEY_EXTENT = 'extent';
    public const string KEY_NAME = 'name';
    public const string KEY_X = 'x';
    public const string KEY_Y = 'y';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RegionInterface;
}
