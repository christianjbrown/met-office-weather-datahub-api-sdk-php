<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;

interface ExtentCustomsTransformerInterface
{
    public const string ARRAY_NAME = 'custom';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExtentCustomInterface>
     */
    public function transform(array $data): array;
}
