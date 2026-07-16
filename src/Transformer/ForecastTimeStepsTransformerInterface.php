<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Model\ForecastTimeStepInterface;

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
