<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;

interface CoverageCollectionTransformerInterface
{
    public const string KEY_COVERAGES = 'coverages';
    public const string KEY_DOMAIN_TYPE = 'domainType';
    public const string KEY_REFERENCING = 'referencing';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CoverageCollectionInterface;
}
