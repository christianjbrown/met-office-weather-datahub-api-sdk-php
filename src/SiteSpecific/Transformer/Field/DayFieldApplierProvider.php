<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformerInterface;

/**
 * Field appliers for the daytime values of a daily forecast time step.
 */
final class DayFieldApplierProvider implements DailyForecastFieldApplierProviderInterface
{
    /**
     * @return DailyForecastFieldApplierInterface[]
     */
    public function appliers(): array
    {
        return [
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayLowerBoundMaxFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayLowerBoundMaxTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayMaxFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_SCREEN_TEMPERATURE, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayMaxScreenTemperature($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HAIL, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfHail($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfHeavyRain($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfHeavySnow($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_PRECIPITATION, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfPrecipitation($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_RAIN, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfRain($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SFERICS, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfSferics($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SNOW, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setDayProbabilityOfSnow($value)),
            new WeatherTypeFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_SIGNIFICANT_WEATHER_CODE, static fn (DailyForecastTimeStepInterface $timeStep, WeatherType $value): mixed => $timeStep->setDaySignificantWeatherCode($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayUpperBoundMaxFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setDayUpperBoundMaxTemp($value)),
        ];
    }
}
