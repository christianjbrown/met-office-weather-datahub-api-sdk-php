<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;

interface ForecastTimeStepsTransformerInterface
{
    public const ARRAY_NAME = 'timeSeries';
    public const UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ForecastTimeStepInterface>
     */
    public function transform(array $data): array;
}
