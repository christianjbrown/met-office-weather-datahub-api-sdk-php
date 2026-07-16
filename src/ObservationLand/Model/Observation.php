<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Enums\WindDirection;

final class Observation implements ObservationInterface
{
    private int $datetime;
    private ?int $humidity = null;
    private ?int $mslp = null;
    private ?string $pressureTendency = null;
    private ?float $temperature = null;
    private ?float $visibility = null;
    private ?WeatherType $weatherCode = null;
    private ?WindDirection $windDirection = null;
    private ?float $windGust = null;
    private ?float $windSpeed = null;

    public function __construct(int $datetime)
    {
        $this->datetime = $datetime;
    }

    public function getDatetime(): int
    {
        return $this->datetime;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function getMslp(): ?int
    {
        return $this->mslp;
    }

    public function getPressureTendency(): ?string
    {
        return $this->pressureTendency;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function getVisibility(): ?float
    {
        return $this->visibility;
    }

    public function getWeatherCode(): ?WeatherType
    {
        return $this->weatherCode;
    }

    public function getWindDirection(): ?WindDirection
    {
        return $this->windDirection;
    }

    public function getWindGust(): ?float
    {
        return $this->windGust;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setDatetime(int $value): ObservationInterface
    {
        $this->datetime = $value;

        return $this;
    }

    public function setHumidity(?int $value): ObservationInterface
    {
        $this->humidity = $value;

        return $this;
    }

    public function setMslp(?int $value): ObservationInterface
    {
        $this->mslp = $value;

        return $this;
    }

    public function setPressureTendency(?string $value): ObservationInterface
    {
        $this->pressureTendency = $value;

        return $this;
    }

    public function setTemperature(?float $value): ObservationInterface
    {
        $this->temperature = $value;

        return $this;
    }

    public function setVisibility(?float $value): ObservationInterface
    {
        $this->visibility = $value;

        return $this;
    }

    public function setWeatherCode(?WeatherType $value): ObservationInterface
    {
        $this->weatherCode = $value;

        return $this;
    }

    public function setWindDirection(?WindDirection $value): ObservationInterface
    {
        $this->windDirection = $value;

        return $this;
    }

    public function setWindGust(?float $value): ObservationInterface
    {
        $this->windGust = $value;

        return $this;
    }

    public function setWindSpeed(?float $value): ObservationInterface
    {
        $this->windSpeed = $value;

        return $this;
    }
}
