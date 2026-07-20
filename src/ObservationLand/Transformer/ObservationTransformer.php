<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Enums\WindDirection;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\Observation;
use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;

use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class ObservationTransformer implements ObservationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ObservationInterface
    {
        if (empty($data[self::KEY_DATETIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DATETIME));
        }
        if (!is_string($data[self::KEY_DATETIME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DATETIME));
        }
        $datetime = strtotime($data[self::KEY_DATETIME]);
        if (false === $datetime) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_TIMESTAMP_SPRINTF, $data[self::KEY_DATETIME]));
        }
        $observation = new Observation($datetime);

        $this->applyHumidity($observation, $data);
        $this->applyMslp($observation, $data);
        $this->applyPressureTendency($observation, $data);
        $this->applyTemperature($observation, $data);
        $this->applyVisibility($observation, $data);
        $this->applyWeatherCode($observation, $data);
        $this->applyWindDirection($observation, $data);
        $this->applyWindGust($observation, $data);
        $this->applyWindSpeed($observation, $data);

        return $observation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHumidity(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_HUMIDITY])) {
            return;
        }
        if (!is_int($data[self::KEY_HUMIDITY])) {
            return;
        }
        $observation->setHumidity($data[self::KEY_HUMIDITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMslp(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_MSLP])) {
            return;
        }
        if (!is_int($data[self::KEY_MSLP])) {
            return;
        }
        $observation->setMslp($data[self::KEY_MSLP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPressureTendency(Observation $observation, array $data): void
    {
        if (empty($data[self::KEY_PRESSURE_TENDENCY])) {
            return;
        }
        if (!is_string($data[self::KEY_PRESSURE_TENDENCY])) {
            return;
        }
        $observation->setPressureTendency($data[self::KEY_PRESSURE_TENDENCY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTemperature(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_TEMPERATURE])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_TEMPERATURE]);
        if (null === $value) {
            return;
        }
        $observation->setTemperature($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibility(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_VISIBILITY])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_VISIBILITY]);
        if (null === $value) {
            return;
        }
        $observation->setVisibility($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWeatherCode(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_WEATHER_CODE])) {
            return;
        }
        if (!is_int($data[self::KEY_WEATHER_CODE])) {
            return;
        }
        $weatherType = WeatherType::tryFrom($data[self::KEY_WEATHER_CODE]);
        if (null === $weatherType) {
            return;
        }
        $observation->setWeatherCode($weatherType);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWindDirection(Observation $observation, array $data): void
    {
        if (empty($data[self::KEY_WIND_DIRECTION])) {
            return;
        }
        if (!is_string($data[self::KEY_WIND_DIRECTION])) {
            return;
        }
        $windDirection = WindDirection::tryFrom($data[self::KEY_WIND_DIRECTION]);
        if (null === $windDirection) {
            return;
        }
        $observation->setWindDirection($windDirection);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWindGust(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_WIND_GUST])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_WIND_GUST]);
        if (null === $value) {
            return;
        }
        $observation->setWindGust($value);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWindSpeed(Observation $observation, array $data): void
    {
        if (!isset($data[self::KEY_WIND_SPEED])) {
            return;
        }
        $value = $this->toFloat($data[self::KEY_WIND_SPEED]);
        if (null === $value) {
            return;
        }
        $observation->setWindSpeed($value);
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
