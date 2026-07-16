<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\MapImages\Model\ParameterDetailInterface;

interface ParameterDetailsTransformerInterface
{
    public const ARRAY_NAME = 'parameterDetails';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ParameterDetailInterface>
     */
    public function transform(array $data): array;
}
