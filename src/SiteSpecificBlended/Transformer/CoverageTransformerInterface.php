<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;

interface CoverageTransformerInterface
{
    public const string KEY_DOMAIN = 'domain';
    public const string KEY_RANGES = 'ranges';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CoverageInterface;
}
