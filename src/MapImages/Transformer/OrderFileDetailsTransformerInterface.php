<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\OrderFileDetailsInterface;

interface OrderFileDetailsTransformerInterface
{
    public const KEY_FILE = 'file';
    public const KEY_PARAMETER_DETAILS = 'parameterDetails';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileDetailsInterface;
}
