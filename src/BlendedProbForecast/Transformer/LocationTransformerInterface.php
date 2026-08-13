<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\LocationInterface;

interface LocationTransformerInterface
{
    public const string KEY_COORDINATES = 'coordinates';
    public const string KEY_GEOMETRY = 'geometry';
    public const string KEY_ID = 'id';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface;
}
