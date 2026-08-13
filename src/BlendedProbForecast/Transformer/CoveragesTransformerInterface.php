<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageInterface;

interface CoveragesTransformerInterface
{
    public const string ARRAY_NAME = 'coverages';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CoverageInterface>
     */
    public function transform(array $data): array;
}
