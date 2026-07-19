<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;

interface OrderFileTransformerInterface
{
    public const KEY_FILE_ID = 'fileId';
    public const KEY_LEVELS = 'levels';
    public const KEY_PARAMETERS = 'parameters';
    public const KEY_REGION = 'region';
    public const KEY_RUN = 'run';
    public const KEY_RUN_DATE_TIME = 'runDateTime';
    public const KEY_SURFACE_ID = 'surfaceId';
    public const KEY_TIMESTEPS = 'timesteps';
    public const UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileInterface;
}
