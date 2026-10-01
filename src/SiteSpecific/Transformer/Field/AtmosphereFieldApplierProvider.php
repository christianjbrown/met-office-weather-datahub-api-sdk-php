<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformerInterface;

/**
 * Field appliers for the midday and midnight values and the UV index of a daily forecast time step.
 */
final class AtmosphereFieldApplierProvider implements DailyForecastFieldApplierProviderInterface
{
    /**
     * @return DailyForecastFieldApplierInterface[]
     */
    public function appliers(): array
    {
        return [
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MAX_UV_INDEX, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMaxUvIndex($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_DIRECTION, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMidday10MWindDirection($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_GUST, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMidday10MWindGust($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_SPEED, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMidday10MWindSpeed($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_MSLP, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMiddayMslp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_RELATIVE_HUMIDITY, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMiddayRelativeHumidity($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_VISIBILITY, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMiddayVisibility($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_DIRECTION, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMidnight10MWindDirection($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_GUST, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMidnight10MWindGust($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_SPEED, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMidnight10MWindSpeed($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_MSLP, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMidnightMslp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_RELATIVE_HUMIDITY, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setMidnightRelativeHumidity($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_VISIBILITY, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setMidnightVisibility($value)),
        ];
    }
}
