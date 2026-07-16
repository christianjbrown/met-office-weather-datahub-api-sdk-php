<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Model\ForecastInterface;

interface ForecastTransformerInterface
{
    public const KEY_LOCATION = 'location';
    public const KEY_MODEL_RUN_DATE = 'modelRunDate';
    public const KEY_NAME = 'name';
    public const KEY_TIME_SERIES = 'timeSeries';

    /**
     * @param mixed[] $properties
     */
    public function transform(array $properties): ForecastInterface;
}
