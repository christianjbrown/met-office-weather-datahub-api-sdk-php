<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

interface HourlyForecastTimeStepInterface extends ForecastTimeStepInterface
{
    public function getFeelsLikeTemperature(): ?float;

    public function getMax10mWindGust(): ?float;

    public function getMaxScreenAirTemp(): ?float;

    public function getMinScreenAirTemp(): ?float;

    public function getMslp(): ?int;

    public function getPrecipitationRate(): ?float;

    public function getProbOfPrecipitation(): ?int;

    public function getScreenDewPointTemperature(): ?float;

    public function getScreenRelativeHumidity(): ?float;

    public function getScreenTemperature(): ?float;

    public function getSignificantWeatherCode(): ?WeatherType;

    public function getTotalPrecipAmount(): ?float;

    public function getTotalSnowAmount(): ?float;

    public function getUvIndex(): ?int;

    public function getVisibility(): ?int;

    public function getWindDirectionFrom10m(): ?int;

    public function getWindGustSpeed10m(): ?float;

    public function getWindSpeed10m(): ?float;

    public function setFeelsLikeTemperature(?float $value): self;

    public function setMax10mWindGust(?float $value): self;

    public function setMaxScreenAirTemp(?float $value): self;

    public function setMinScreenAirTemp(?float $value): self;

    public function setMslp(?int $value): self;

    public function setPrecipitationRate(?float $value): self;

    public function setProbOfPrecipitation(?int $value): self;

    public function setScreenDewPointTemperature(?float $value): self;

    public function setScreenRelativeHumidity(?float $value): self;

    public function setScreenTemperature(?float $value): self;

    public function setSignificantWeatherCode(?WeatherType $value): self;

    public function setTime(int $value): self;

    public function setTotalPrecipAmount(?float $value): self;

    public function setTotalSnowAmount(?float $value): self;

    public function setUvIndex(?int $value): self;

    public function setVisibility(?int $value): self;

    public function setWindDirectionFrom10m(?int $value): self;

    public function setWindGustSpeed10m(?float $value): self;

    public function setWindSpeed10m(?float $value): self;
}
