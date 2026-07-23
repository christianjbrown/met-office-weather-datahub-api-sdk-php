<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\ThreeHourlyForecastTimeStep;
use ChristianBrown\MetOffice\SiteSpecific\Model\ThreeHourlyForecastTimeStepInterface;

use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class ThreeHourlyForecastTimeStepTransformer implements ThreeHourlyForecastTimeStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ThreeHourlyForecastTimeStepInterface
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
        $timeStep = new ThreeHourlyForecastTimeStep($time);

        self::applyFeelsLikeTemp($timeStep, $data);
        self::applyMax10mWindGust($timeStep, $data);
        self::applyMaxScreenAirTemp($timeStep, $data);
        self::applyMinScreenAirTemp($timeStep, $data);
        self::applyMslp($timeStep, $data);
        self::applyProbOfHail($timeStep, $data);
        self::applyProbOfHeavyRain($timeStep, $data);
        self::applyProbOfHeavySnow($timeStep, $data);
        self::applyProbOfPrecipitation($timeStep, $data);
        self::applyProbOfRain($timeStep, $data);
        self::applyProbOfSferics($timeStep, $data);
        self::applyProbOfSnow($timeStep, $data);
        self::applyScreenRelativeHumidity($timeStep, $data);
        self::applySignificantWeatherCode($timeStep, $data);
        self::applyTotalPrecipAmount($timeStep, $data);
        self::applyTotalSnowAmount($timeStep, $data);
        self::applyUvIndex($timeStep, $data);
        self::applyVisibility($timeStep, $data);
        self::applyWindDirectionFrom10m($timeStep, $data);
        self::applyWindGustSpeed10m($timeStep, $data);
        self::applyWindSpeed10m($timeStep, $data);

        return $timeStep;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFeelsLikeTemp(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_FEELS_LIKE_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_FEELS_LIKE_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setFeelsLikeTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMax10mWindGust(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MAX10M_WIND_GUST])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MAX10M_WIND_GUST]);
        if (null === $value) {
            return;
        }
        $timeStep->setMax10mWindGust($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaxScreenAirTemp(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MAX_SCREEN_AIR_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MAX_SCREEN_AIR_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setMaxScreenAirTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMinScreenAirTemp(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIN_SCREEN_AIR_TEMP])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_MIN_SCREEN_AIR_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setMinScreenAirTemp($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMslp(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MSLP])) {
            return;
        }
        if (!is_int($data[self::KEY_MSLP])) {
            return;
        }
        $timeStep->setMslp($data[self::KEY_MSLP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfHail(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_HAIL])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_HAIL])) {
            return;
        }
        $timeStep->setProbOfHail($data[self::KEY_PROB_OF_HAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfHeavyRain(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_HEAVY_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_HEAVY_RAIN])) {
            return;
        }
        $timeStep->setProbOfHeavyRain($data[self::KEY_PROB_OF_HEAVY_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfHeavySnow(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_HEAVY_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_HEAVY_SNOW])) {
            return;
        }
        $timeStep->setProbOfHeavySnow($data[self::KEY_PROB_OF_HEAVY_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfPrecipitation(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_PRECIPITATION])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_PRECIPITATION])) {
            return;
        }
        $timeStep->setProbOfPrecipitation($data[self::KEY_PROB_OF_PRECIPITATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfRain(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_RAIN])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_RAIN])) {
            return;
        }
        $timeStep->setProbOfRain($data[self::KEY_PROB_OF_RAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfSferics(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_SFERICS])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_SFERICS])) {
            return;
        }
        $timeStep->setProbOfSferics($data[self::KEY_PROB_OF_SFERICS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProbOfSnow(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_SNOW])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_SNOW])) {
            return;
        }
        $timeStep->setProbOfSnow($data[self::KEY_PROB_OF_SNOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyScreenRelativeHumidity(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_SCREEN_RELATIVE_HUMIDITY])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_SCREEN_RELATIVE_HUMIDITY]);
        if (null === $value) {
            return;
        }
        $timeStep->setScreenRelativeHumidity($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySignificantWeatherCode(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        if (!is_int($data[self::KEY_SIGNIFICANT_WEATHER_CODE])) {
            return;
        }
        $weatherType = WeatherType::tryFrom($data[self::KEY_SIGNIFICANT_WEATHER_CODE]);
        if (null === $weatherType) {
            return;
        }
        $timeStep->setSignificantWeatherCode($weatherType);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotalPrecipAmount(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL_PRECIP_AMOUNT])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_TOTAL_PRECIP_AMOUNT]);
        if (null === $value) {
            return;
        }
        $timeStep->setTotalPrecipAmount($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotalSnowAmount(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL_SNOW_AMOUNT])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_TOTAL_SNOW_AMOUNT]);
        if (null === $value) {
            return;
        }
        $timeStep->setTotalSnowAmount($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUvIndex(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_UV_INDEX])) {
            return;
        }
        if (!is_int($data[self::KEY_UV_INDEX])) {
            return;
        }
        $timeStep->setUvIndex($data[self::KEY_UV_INDEX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVisibility(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_VISIBILITY])) {
            return;
        }
        if (!is_int($data[self::KEY_VISIBILITY])) {
            return;
        }
        $timeStep->setVisibility($data[self::KEY_VISIBILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWindDirectionFrom10m(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_DIRECTION_FROM10M])) {
            return;
        }
        if (!is_int($data[self::KEY_WIND_DIRECTION_FROM10M])) {
            return;
        }
        $timeStep->setWindDirectionFrom10m($data[self::KEY_WIND_DIRECTION_FROM10M]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWindGustSpeed10m(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_GUST_SPEED10M])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_WIND_GUST_SPEED10M]);
        if (null === $value) {
            return;
        }
        $timeStep->setWindGustSpeed10m($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWindSpeed10m(ThreeHourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_SPEED10M])) {
            return;
        }
        $value = self::toFloat($data[self::KEY_WIND_SPEED10M]);
        if (null === $value) {
            return;
        }
        $timeStep->setWindSpeed10m($value);
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
