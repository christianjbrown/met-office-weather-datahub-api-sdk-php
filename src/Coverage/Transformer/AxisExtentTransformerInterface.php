<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\AxisExtentInterface;

interface AxisExtentTransformerInterface
{
    public const string KEY_LABEL = 'label';
    public const string KEY_LOWER_BOUND = 'lowerBound';
    public const string KEY_UOM_LABEL = 'uomLabel';
    public const string KEY_UPPER_BOUND = 'upperBound';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AxisExtentInterface;
}
