<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollectionInterface;

interface CoverageCollectionTransformerInterface
{
    public const string KEY_COVERAGES = 'coverages';
    public const string KEY_DOMAIN_TYPE = 'domainType';
    public const string KEY_PARAMETERS = 'parameters';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CoverageCollectionInterface;
}
