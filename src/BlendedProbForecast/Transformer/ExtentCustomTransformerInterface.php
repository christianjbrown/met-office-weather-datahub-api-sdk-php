<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;

interface ExtentCustomTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_INTERVAL = 'interval';
    public const string KEY_REFERENCE = 'reference';
    public const string KEY_VALUES = 'values';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExtentCustomInterface;
}
