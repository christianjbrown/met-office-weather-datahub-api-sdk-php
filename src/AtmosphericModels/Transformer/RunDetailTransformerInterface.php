<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RunDetailInterface;

interface RunDetailTransformerInterface
{
    public const KEY_RUN = 'run';
    public const KEY_RUN_DATE_TIME = 'runDateTime';
    public const KEY_RUN_FILTER = 'runFilter';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';
    public const UNEXPECTED_TIMESTAMP_SPRINTF = '%s not a valid timestamp';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RunDetailInterface;
}
