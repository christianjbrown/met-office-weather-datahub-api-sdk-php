<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ExtentInterface;

interface ExtentTransformerInterface
{
    public const string KEY_BBOX = 'bbox';
    public const string KEY_CRS = 'crs';
    public const string KEY_INTERVAL = 'interval';
    public const string KEY_SPATIAL = 'spatial';
    public const string KEY_TEMPORAL = 'temporal';
    public const string KEY_VALUES = 'values';
    public const string KEY_VERTICAL = 'vertical';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtentInterface;
}
