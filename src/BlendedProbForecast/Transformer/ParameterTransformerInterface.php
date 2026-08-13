<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;

interface ParameterTransformerInterface
{
    public const string KEY_CUSTOM = 'custom';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_EN = 'en';
    public const string KEY_FILE_SUFFIX = 'fileSuffix';
    public const string KEY_HEIGHT = 'height';
    public const string KEY_ID = 'id';
    public const string KEY_LABEL = 'label';
    public const string KEY_OBSERVED_PROPERTY = 'observedProperty';
    public const string KEY_SYMBOL = 'symbol';
    public const string KEY_UNIT = 'unit';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ParameterInterface;
}
