<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;

interface OrderFileTransformerInterface
{
    public const string KEY_FILE_ID = 'fileId';
    public const string KEY_LEVELS = 'levels';
    public const string KEY_PARAMETERS = 'parameters';
    public const string KEY_REGION = 'region';
    public const string KEY_RUN = 'run';
    public const string KEY_RUN_DATE_TIME = 'runDateTime';
    public const string KEY_SURFACE_ID = 'surfaceId';
    public const string KEY_TIMESTEPS = 'timesteps';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderFileInterface;
}
