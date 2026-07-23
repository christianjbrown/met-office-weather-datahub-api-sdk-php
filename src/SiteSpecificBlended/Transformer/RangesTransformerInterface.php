<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArrayInterface;

interface RangesTransformerInterface
{
    public const string ARRAY_NAME = 'ranges';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<string, NdArrayInterface>
     */
    public function transform(array $data): array;
}
