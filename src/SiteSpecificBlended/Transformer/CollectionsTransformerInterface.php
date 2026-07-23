<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;

interface CollectionsTransformerInterface
{
    public const string ARRAY_NAME = 'collections';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, CollectionInterface>
     */
    public function transform(array $data): array;
}
