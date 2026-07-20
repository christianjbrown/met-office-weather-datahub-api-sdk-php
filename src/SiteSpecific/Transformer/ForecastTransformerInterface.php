<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;

interface ForecastTransformerInterface
{
    public const string KEY_LOCATION = 'location';
    public const string KEY_MODEL_RUN_DATE = 'modelRunDate';
    public const string KEY_NAME = 'name';
    public const string KEY_TIME_SERIES = 'timeSeries';

    /**
     * @param mixed[] $properties
     */
    public function transform(array $properties): ForecastInterface;
}
