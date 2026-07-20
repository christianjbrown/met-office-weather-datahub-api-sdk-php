<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RunDetailInterface;

interface RunDetailTransformerInterface
{
    public const string KEY_RUN = 'run';
    public const string KEY_RUN_DATE_TIME = 'runDateTime';
    public const string KEY_RUN_FILTER = 'runFilter';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const string UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunDetailInterface;
}
