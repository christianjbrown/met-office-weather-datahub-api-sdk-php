<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\AxisExtentInterface;

interface AxisExtentTransformerInterface
{
    public const KEY_LABEL = 'label';
    public const KEY_LOWER_BOUND = 'lowerBound';
    public const KEY_UOM_LABEL = 'uomLabel';
    public const KEY_UPPER_BOUND = 'upperBound';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AxisExtentInterface;
}
