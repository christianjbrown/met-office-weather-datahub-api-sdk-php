<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;

interface ReferenceSystemTransformerInterface
{
    public const string KEY_CALENDAR = 'calendar';
    public const string KEY_COORDINATES = 'coordinates';
    public const string KEY_EN = 'en';
    public const string KEY_ID = 'id';
    public const string KEY_IDENTIFIERS = 'identifiers';
    public const string KEY_LABEL = 'label';
    public const string KEY_SYSTEM = 'system';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReferenceSystemInterface;
}
