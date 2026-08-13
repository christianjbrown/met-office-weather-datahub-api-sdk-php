<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\AxisInterface;

interface AxisTransformerInterface
{
    public const string KEY_BOUNDS = 'bounds';
    public const string KEY_NAME = 'name';
    public const string KEY_VALUES = 'values';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AxisInterface;
}
