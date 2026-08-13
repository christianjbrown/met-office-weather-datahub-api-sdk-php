<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;

interface InstanceTransformerInterface
{
    public const string KEY_CRS = 'crs';
    public const string KEY_DATA_QUERIES = 'data_queries';
    public const string KEY_EXTENT = 'extent';
    public const string KEY_ID = 'id';
    public const string KEY_LINKS = 'links';
    public const string KEY_OUTPUT_FORMATS = 'output_formats';
    public const string KEY_PARAMETER_NAMES = 'parameter_names';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstanceInterface;
}
