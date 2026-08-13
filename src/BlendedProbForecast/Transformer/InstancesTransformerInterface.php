<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;

interface InstancesTransformerInterface
{
    public const string ARRAY_NAME = 'instances';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstanceInterface>
     */
    public function transform(array $data): array;
}
