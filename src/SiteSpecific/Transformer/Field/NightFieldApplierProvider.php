<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer\Field;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformerInterface;

/**
 * Field appliers for the night values of a daily forecast time step.
 */
final class NightFieldApplierProvider implements DailyForecastFieldApplierProviderInterface
{
    /**
     * @return DailyForecastFieldApplierInterface[]
     */
    public function appliers(): array
    {
        return [
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightLowerBoundMinFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightLowerBoundMinTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightMinFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_SCREEN_TEMPERATURE, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightMinScreenTemperature($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HAIL, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfHail($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfHeavyRain($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfHeavySnow($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfPrecipitation($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_RAIN, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfRain($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SFERICS, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfSferics($value)),
            new IntFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SNOW, static fn (DailyForecastTimeStepInterface $timeStep, int $value): mixed => $timeStep->setNightProbabilityOfSnow($value)),
            new WeatherTypeFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE, static fn (DailyForecastTimeStepInterface $timeStep, WeatherType $value): mixed => $timeStep->setNightSignificantWeatherCode($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightUpperBoundMinFeelsLikeTemp($value)),
            new FloatFieldApplier(DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_TEMP, static fn (DailyForecastTimeStepInterface $timeStep, float $value): mixed => $timeStep->setNightUpperBoundMinTemp($value)),
        ];
    }
}
