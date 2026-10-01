<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

interface DailyForecastFieldApplierProviderInterface
{
    /**
     * @return DailyForecastFieldApplierInterface[]
     */
    public function appliers(): array;
}
