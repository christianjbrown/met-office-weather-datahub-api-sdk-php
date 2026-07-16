<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Model\HourlyForecastTimeStep;
use ChristianBrown\MetOffice\Model\HourlyForecastTimeStepInterface;

use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class HourlyForecastTimeStepTransformer implements HourlyForecastTimeStepTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HourlyForecastTimeStepInterface
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
        $timeStep = new HourlyForecastTimeStep($time);

        $this->applyFeelsLikeTemperature($timeStep, $data);
        $this->applyMax10mWindGust($timeStep, $data);
        $this->applyMaxScreenAirTemp($timeStep, $data);
        $this->applyMinScreenAirTemp($timeStep, $data);
        $this->applyMslp($timeStep, $data);
        $this->applyPrecipitationRate($timeStep, $data);
        $this->applyProbOfPrecipitation($timeStep, $data);
        $this->applyScreenDewPointTemperature($timeStep, $data);
        $this->applyScreenRelativeHumidity($timeStep, $data);
        $this->applyScreenTemperature($timeStep, $data);
        $this->applySignificantWeatherCode($timeStep, $data);
        $this->applyTotalPrecipAmount($timeStep, $data);
        $this->applyTotalSnowAmount($timeStep, $data);
        $this->applyUvIndex($timeStep, $data);
        $this->applyVisibility($timeStep, $data);
        $this->applyWindDirectionFrom10m($timeStep, $data);
        $this->applyWindGustSpeed10m($timeStep, $data);
        $this->applyWindSpeed10m($timeStep, $data);

        return $timeStep;
    }

    private function applyFeelsLikeTemperature(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_FEELS_LIKE_TEMPERATURE])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_FEELS_LIKE_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $timeStep->setFeelsLikeTemperature($value);
    }

    private function applyMax10mWindGust(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MAX10M_WIND_GUST])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_MAX10M_WIND_GUST]);
        if (null === $value) {
            return;
        }
        $timeStep->setMax10mWindGust($value);
    }

    private function applyMaxScreenAirTemp(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MAX_SCREEN_AIR_TEMP])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_MAX_SCREEN_AIR_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setMaxScreenAirTemp($value);
    }

    private function applyMinScreenAirTemp(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MIN_SCREEN_AIR_TEMP])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_MIN_SCREEN_AIR_TEMP]);
        if (null === $value) {
            return;
        }
        $timeStep->setMinScreenAirTemp($value);
    }

    private function applyMslp(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_MSLP])) {
            return;
        }
        if (!is_int($data[self::KEY_MSLP])) {
            return;
        }
        $timeStep->setMslp($data[self::KEY_MSLP]);
    }

    private function applyPrecipitationRate(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PRECIPITATION_RATE])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_PRECIPITATION_RATE]);
        if (null === $value) {
            return;
        }
        $timeStep->setPrecipitationRate($value);
    }

    private function applyProbOfPrecipitation(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_PROB_OF_PRECIPITATION])) {
            return;
        }
        if (!is_int($data[self::KEY_PROB_OF_PRECIPITATION])) {
            return;
        }
        $timeStep->setProbOfPrecipitation($data[self::KEY_PROB_OF_PRECIPITATION]);
    }

    private function applyScreenDewPointTemperature(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_SCREEN_DEW_POINT_TEMPERATURE])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_SCREEN_DEW_POINT_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $timeStep->setScreenDewPointTemperature($value);
    }

    private function applyScreenRelativeHumidity(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_SCREEN_RELATIVE_HUMIDITY])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_SCREEN_RELATIVE_HUMIDITY]);
        if (null === $value) {
            return;
        }
        $timeStep->setScreenRelativeHumidity($value);
    }

    private function applyScreenTemperature(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_SCREEN_TEMPERATURE])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_SCREEN_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $timeStep->setScreenTemperature($value);
    }

    private function applySignificantWeatherCode(HourlyForecastTimeStep $timeStep, array $data): void
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

    private function applyTotalPrecipAmount(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL_PRECIP_AMOUNT])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_TOTAL_PRECIP_AMOUNT]);
        if (null === $value) {
            return;
        }
        $timeStep->setTotalPrecipAmount($value);
    }

    private function applyTotalSnowAmount(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL_SNOW_AMOUNT])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_TOTAL_SNOW_AMOUNT]);
        if (null === $value) {
            return;
        }
        $timeStep->setTotalSnowAmount($value);
    }

    private function applyUvIndex(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_UV_INDEX])) {
            return;
        }
        if (!is_int($data[self::KEY_UV_INDEX])) {
            return;
        }
        $timeStep->setUvIndex($data[self::KEY_UV_INDEX]);
    }

    private function applyVisibility(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_VISIBILITY])) {
            return;
        }
        if (!is_int($data[self::KEY_VISIBILITY])) {
            return;
        }
        $timeStep->setVisibility($data[self::KEY_VISIBILITY]);
    }

    private function applyWindDirectionFrom10m(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_DIRECTION_FROM10M])) {
            return;
        }
        if (!is_int($data[self::KEY_WIND_DIRECTION_FROM10M])) {
            return;
        }
        $timeStep->setWindDirectionFrom10m($data[self::KEY_WIND_DIRECTION_FROM10M]);
    }

    private function applyWindGustSpeed10m(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_GUST_SPEED10M])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_WIND_GUST_SPEED10M]);
        if (null === $value) {
            return;
        }
        $timeStep->setWindGustSpeed10m($value);
    }

    private function applyWindSpeed10m(HourlyForecastTimeStep $timeStep, array $data): void
    {
        if (!isset($data[self::KEY_WIND_SPEED10M])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_WIND_SPEED10M]);
        if (null === $value) {
            return;
        }
        $timeStep->setWindSpeed10m($value);
    }

    private function toFloat(mixed $value): ?float
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
