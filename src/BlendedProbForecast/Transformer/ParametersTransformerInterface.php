<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;

interface ParametersTransformerInterface
{
    public const string ARRAY_NAME = 'parameters';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<string, ParameterInterface>
     */
    public function transform(array $data): array;
}
