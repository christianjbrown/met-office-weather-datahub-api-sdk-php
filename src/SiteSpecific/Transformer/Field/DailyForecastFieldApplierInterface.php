<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;

/**
 * Copies one field of a daily forecast time step payload onto the model,
 * leaving the model untouched when the field is missing or has an
 * unexpected type.
 */
interface DailyForecastFieldApplierInterface
{
    /**
     * @phpstan-param mixed[] $data
     */
    public function apply(DailyForecastTimeStepInterface $timeStep, array $data): void;
}
