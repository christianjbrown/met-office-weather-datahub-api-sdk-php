<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;

interface LinksTransformerInterface
{
    public const string ARRAY_NAME = 'links';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LinkInterface>
     */
    public function transform(array $data): array;
}
