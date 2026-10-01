<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

interface DailyForecastTimeStepTransformerFactoryInterface
{
    public function create(): DailyForecastTimeStepTransformerInterface;
}
