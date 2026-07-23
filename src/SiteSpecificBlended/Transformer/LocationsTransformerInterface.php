<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;

interface LocationsTransformerInterface
{
    public const string ARRAY_NAME = 'features';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocationInterface>
     */
    public function transform(array $data): array;
}
