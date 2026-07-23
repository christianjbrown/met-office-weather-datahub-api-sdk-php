<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStep;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStepInterface;

use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class DailyForecastTimeStepTransformer implements DailyForecastTimeStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DailyForecastTimeStepInterface
    {
        if (empty($data[self::KEY_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME));
        }
        if (!is_string($data[self::KEY_TIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME));
        }
        $time = strtotime($data[self::KEY_TIME]);
        if (false === $time) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_TIMESTAMP_SPRINTF, $data[self::KEY_TIME]));
        }
        $timeStep = new DailyForecastTimeStep($time);

        self::applyDayLowerBoundMaxFeelsLikeTemp($timeStep, $data);
        self::applyDayLowerBoundMaxTemp($timeStep, $data);
        self::applyDayMaxFeelsLikeTemp($timeStep, $data);
        self::applyDayMaxScreenTemperature($timeStep, $data);
        self::applyDayProbabilityOfHail($timeStep, $data);
        self::applyDayProbabilityOfHeavyRain($timeStep, $data);
        self::applyDayProbabilityOfHeavySnow($timeStep, $data);
        self::applyDayProbabilityOfPrecipitation($timeStep, $data);
        self::applyDayProbabilityOfRain($timeStep, $data);
        self::applyDayProbabilityOfSferics($timeStep, $data);
        self::applyDayProbabilityOfSnow($timeStep, $data);
        self::applyDaySignificantWeatherCode($timeStep, $data);
        self::applyDayUpperBoundMaxFeelsLikeTemp($timeStep, $data);
        self::applyDayUpperBoundMaxTemp($timeStep, $data);
        self::applyMaxUvIndex($timeStep, $data);
        self::applyMidday10MWindDirection($timeStep, $data);
        self::applyMidday10MWindGust($timeStep, $data);
        self::applyMidday10MWindSpeed($timeStep, $data);
        self::applyMiddayMslp($timeStep, $data);
        self::applyMiddayRelativeHumidity($timeStep, $data);
        self::applyMiddayVisibility($timeStep, $data);
        self::applyMidnight10MWindDirection($timeStep, $data);
        self::applyMidnight10MWindGust($timeStep, $data);
        self::applyMidnight10MWindSpeed($timeStep, $data);
        self::applyMidnightMslp($timeStep, $data);
        self::applyMidnightRelativeHumidity($timeStep, $data);
        self::applyMidnightVisibility($timeStep, $data);
        self::applyNightLowerBoundMinFeelsLikeTemp($timeStep, $data);
        self::applyNightLowerBoundMinTemp($timeStep, $data);
        self::applyNightMinFeelsLikeTemp($timeStep, $data);
        self::applyNightMinScreenTemperature($timeStep, $data);
        self::applyNightProbabilityOfHail($timeStep, $data);
        self::applyNightProbabilityOfHeavyRain($timeStep, $data);
        self::applyNightProbabilityOfHeavySnow($timeStep, $data);
        self::applyNightProbabilityOfPrecipitation($timeStep, $data);
        self::applyNightProbabilityOfRain($timeStep, $data);
        self::applyNightProbabilityOfSferics($timeStep, $data);
        self::applyNightProbabilityOfSnow($timeStep, $data);
        self::applyNightSignificantWeatherCode($timeStep, $data);
        self::applyNightUpperBoundMinFeelsLikeTemp($timeStep, $data);
        self::applyNightUpperBoundMinTemp($timeStep, $data);

        return $timeStep;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayLowerBoundMaxFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayLowerBoundMaxFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayLowerBoundMaxTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_LOWER_BOUND_MAX_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_LOWER_BOUND_MAX_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayLowerBoundMaxTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayMaxFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_MAX_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_MAX_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayMaxFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayMaxScreenTemperature(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_MAX_SCREEN_TEMPERATURE])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_MAX_SCREEN_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayMaxScreenTemperature($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfHail(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_HAIL])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_HAIL])) {
            return;
        }
        $timeStep->setDayProbabilityOfHail($data[self::KEY_DAY_PROBABILITY_OF_HAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfHeavyRain(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN])) {
            return;
        }
        $timeStep->setDayProbabilityOfHeavyRain($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfHeavySnow(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW])) {
            return;
        }
        $timeStep->setDayProbabilityOfHeavySnow($data[self::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfPrecipitation(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_PRECIPITATION])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_PRECIPITATION])) {
            return;
        }
        $timeStep->setDayProbabilityOfPrecipitation($data[self::KEY_DAY_PROBABILITY_OF_PRECIPITATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfRain(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_RAIN])) {
            return;
        }
        $timeStep->setDayProbabilityOfRain($data[self::KEY_DAY_PROBABILITY_OF_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfSferics(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_SFERICS])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_SFERICS])) {
            return;
        }
        $timeStep->setDayProbabilityOfSferics($data[self::KEY_DAY_PROBABILITY_OF_SFERICS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayProbabilityOfSnow(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_PROBABILITY_OF_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_PROBABILITY_OF_SNOW])) {
            return;
        }
        $timeStep->setDayProbabilityOfSnow($data[self::KEY_DAY_PROBABILITY_OF_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDaySignificantWeatherCode(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        $weatherType = WeatherType::tryFrom($data[self::KEY_DAY_SIGNIFICANT_WEATHER_CODE]);
        if (null === $weatherType) {
            return;
        }
        $timeStep->setDaySignificantWeatherCode($weatherType);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayUpperBoundMaxFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayUpperBoundMaxFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDayUpperBoundMaxTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_DAY_UPPER_BOUND_MAX_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_DAY_UPPER_BOUND_MAX_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setDayUpperBoundMaxTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxUvIndex(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MAX_UV_INDEX])) {
            return;
        }
        if (!is_int($data[self::KEY_MAX_UV_INDEX])) {
            return;
        }
        $timeStep->setMaxUvIndex($data[self::KEY_MAX_UV_INDEX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidday10MWindDirection(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY10_M_WIND_DIRECTION])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDDAY10_M_WIND_DIRECTION])) {
            return;
        }
        $timeStep->setMidday10MWindDirection($data[self::KEY_MIDDAY10_M_WIND_DIRECTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidday10MWindGust(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY10_M_WIND_GUST])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDDAY10_M_WIND_GUST]);
        if (null === $value) {
            return;
        }
        $timeStep->setMidday10MWindGust($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidday10MWindSpeed(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY10_M_WIND_SPEED])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDDAY10_M_WIND_SPEED]);
        if (null === $value) {
            return;
        }
        $timeStep->setMidday10MWindSpeed($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMiddayMslp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY_MSLP])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDDAY_MSLP])) {
            return;
        }
        $timeStep->setMiddayMslp($data[self::KEY_MIDDAY_MSLP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMiddayRelativeHumidity(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY_RELATIVE_HUMIDITY])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDDAY_RELATIVE_HUMIDITY]);
        if (null === $value) {
            return;
        }
        $timeStep->setMiddayRelativeHumidity($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMiddayVisibility(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDDAY_VISIBILITY])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDDAY_VISIBILITY])) {
            return;
        }
        $timeStep->setMiddayVisibility($data[self::KEY_MIDDAY_VISIBILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnight10MWindDirection(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT10_M_WIND_DIRECTION])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDNIGHT10_M_WIND_DIRECTION])) {
            return;
        }
        $timeStep->setMidnight10MWindDirection($data[self::KEY_MIDNIGHT10_M_WIND_DIRECTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnight10MWindGust(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT10_M_WIND_GUST])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDNIGHT10_M_WIND_GUST]);
        if (null === $value) {
            return;
        }
        $timeStep->setMidnight10MWindGust($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnight10MWindSpeed(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT10_M_WIND_SPEED])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDNIGHT10_M_WIND_SPEED]);
        if (null === $value) {
            return;
        }
        $timeStep->setMidnight10MWindSpeed($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnightMslp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT_MSLP])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDNIGHT_MSLP])) {
            return;
        }
        $timeStep->setMidnightMslp($data[self::KEY_MIDNIGHT_MSLP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnightRelativeHumidity(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT_RELATIVE_HUMIDITY])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIDNIGHT_RELATIVE_HUMIDITY]);
        if (null === $value) {
            return;
        }
        $timeStep->setMidnightRelativeHumidity($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMidnightVisibility(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIDNIGHT_VISIBILITY])) {
            return;
        }
        if (!is_int($data[self::KEY_MIDNIGHT_VISIBILITY])) {
            return;
        }
        $timeStep->setMidnightVisibility($data[self::KEY_MIDNIGHT_VISIBILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightLowerBoundMinFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightLowerBoundMinFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightLowerBoundMinTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_LOWER_BOUND_MIN_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_LOWER_BOUND_MIN_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightLowerBoundMinTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightMinFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_MIN_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_MIN_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightMinFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightMinScreenTemperature(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_MIN_SCREEN_TEMPERATURE])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_MIN_SCREEN_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightMinScreenTemperature($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfHail(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_HAIL])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_HAIL])) {
            return;
        }
        $timeStep->setNightProbabilityOfHail($data[self::KEY_NIGHT_PROBABILITY_OF_HAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfHeavyRain(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN])) {
            return;
        }
        $timeStep->setNightProbabilityOfHeavyRain($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfHeavySnow(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW])) {
            return;
        }
        $timeStep->setNightProbabilityOfHeavySnow($data[self::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfPrecipitation(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION])) {
            return;
        }
        $timeStep->setNightProbabilityOfPrecipitation($data[self::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfRain(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_RAIN])) {
            return;
        }
        $timeStep->setNightProbabilityOfRain($data[self::KEY_NIGHT_PROBABILITY_OF_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfSferics(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_SFERICS])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_SFERICS])) {
            return;
        }
        $timeStep->setNightProbabilityOfSferics($data[self::KEY_NIGHT_PROBABILITY_OF_SFERICS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightProbabilityOfSnow(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_PROBABILITY_OF_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_PROBABILITY_OF_SNOW])) {
            return;
        }
        $timeStep->setNightProbabilityOfSnow($data[self::KEY_NIGHT_PROBABILITY_OF_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightSignificantWeatherCode(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        if (!is_int($data[self::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        $weatherType = WeatherType::tryFrom($data[self::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE]);
        if (null === $weatherType) {
            return;
        }
        $timeStep->setNightSignificantWeatherCode($weatherType);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightUpperBoundMinFeelsLikeTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightUpperBoundMinFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNightUpperBoundMinTemp(DailyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_NIGHT_UPPER_BOUND_MIN_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_NIGHT_UPPER_BOUND_MIN_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setNightUpperBoundMinTemp($value);
    }

    private static function toFloat(mixed $value): ?float
    {
        if (is_int($value)) {
            return (float) $value;
        }
        if (is_float($value)) {
            return $value;
        }

        return null;
    }
}
