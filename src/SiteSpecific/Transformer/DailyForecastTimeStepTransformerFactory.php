<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\AtmosphereFieldApplierProvider;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\DayFieldApplierProvider;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\Field\NightFieldApplierProvider;

use function array_merge;

/**
 * Composition root for the daily time step transformer and its field
 * appliers.
 */
final class DailyForecastTimeStepTransformerFactory implements DailyForecastTimeStepTransformerFactoryInterface
{
    public function create(): DailyForecastTimeStepTransformerInterface
    {
        return new DailyForecastTimeStepTransformer(
            array_merge(
                (new DayFieldApplierProvider())->appliers(),
                (new AtmosphereFieldApplierProvider())->appliers(),
                (new NightFieldApplierProvider())->appliers(),
            )
        );
    }
}
