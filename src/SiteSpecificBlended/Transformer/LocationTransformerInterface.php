<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;

interface LocationTransformerInterface
{
    public const string KEY_COORDINATES = 'coordinates';
    public const string KEY_GEOMETRY = 'geometry';
    public const string KEY_ID = 'id';
    public const string KEY_NAME = 'name';
    public const string KEY_PROPERTIES = 'properties';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface;
}
