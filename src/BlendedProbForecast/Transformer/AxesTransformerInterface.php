<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\AxisInterface;

interface AxesTransformerInterface
{
    public const string ARRAY_NAME = 'axes';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<string, AxisInterface>
     */
    public function transform(array $data): array;
}
