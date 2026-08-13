<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;

interface ReferencingTransformerInterface
{
    public const string ARRAY_NAME = 'referencing';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ReferenceSystemInterface>
     */
    public function transform(array $data): array;
}
