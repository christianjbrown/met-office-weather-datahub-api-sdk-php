<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

interface ThreeHourlyForecastTimeStepInterface extends ForecastTimeStepInterface
{
    public function getFeelsLikeTemp(): ?float;

    public function getMax10mWindGust(): ?float;

    public function getMaxScreenAirTemp(): ?float;

    public function getMinScreenAirTemp(): ?float;

    public function getMslp(): ?int;

    public function getProbOfHail(): ?int;

    public function getProbOfHeavyRain(): ?int;

    public function getProbOfHeavySnow(): ?int;

    public function getProbOfPrecipitation(): ?int;

    public function getProbOfRain(): ?int;

    public function getProbOfSferics(): ?int;

    public function getProbOfSnow(): ?int;

    public function getScreenRelativeHumidity(): ?float;

    public function getSignificantWeatherCode(): ?WeatherType;

    public function getTotalPrecipAmount(): ?float;

    public function getTotalSnowAmount(): ?float;

    public function getUvIndex(): ?int;

    public function getVisibility(): ?int;

    public function getWindDirectionFrom10m(): ?int;

    public function getWindGustSpeed10m(): ?float;

    public function getWindSpeed10m(): ?float;

    public function setFeelsLikeTemp(?float $value): self;

    public function setMax10mWindGust(?float $value): self;

    public function setMaxScreenAirTemp(?float $value): self;

    public function setMinScreenAirTemp(?float $value): self;

    public function setMslp(?int $value): self;

    public function setProbOfHail(?int $value): self;

    public function setProbOfHeavyRain(?int $value): self;

    public function setProbOfHeavySnow(?int $value): self;

    public function setProbOfPrecipitation(?int $value): self;

    public function setProbOfRain(?int $value): self;

    public function setProbOfSferics(?int $value): self;

    public function setProbOfSnow(?int $value): self;

    public function setScreenRelativeHumidity(?float $value): self;

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
