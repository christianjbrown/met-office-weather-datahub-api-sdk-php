<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

interface DailyForecastTimeStepInterface extends ForecastTimeStepInterface
{
    public function getDayLowerBoundMaxFeelsLikeTemp(): ?float;

    public function getDayLowerBoundMaxTemp(): ?float;

    public function getDayMaxFeelsLikeTemp(): ?float;

    public function getDayMaxScreenTemperature(): ?float;

    public function getDayProbabilityOfHail(): ?int;

    public function getDayProbabilityOfHeavyRain(): ?int;

    public function getDayProbabilityOfHeavySnow(): ?int;

    public function getDayProbabilityOfPrecipitation(): ?int;

    public function getDayProbabilityOfRain(): ?int;

    public function getDayProbabilityOfSferics(): ?int;

    public function getDayProbabilityOfSnow(): ?int;

    public function getDaySignificantWeatherCode(): ?WeatherType;

    public function getDayUpperBoundMaxFeelsLikeTemp(): ?float;

    public function getDayUpperBoundMaxTemp(): ?float;

    public function getMaxUvIndex(): ?int;

    public function getMidday10MWindDirection(): ?int;

    public function getMidday10MWindGust(): ?float;

    public function getMidday10MWindSpeed(): ?float;

    public function getMiddayMslp(): ?int;

    public function getMiddayRelativeHumidity(): ?float;

    public function getMiddayVisibility(): ?int;

    public function getMidnight10MWindDirection(): ?int;

    public function getMidnight10MWindGust(): ?float;

    public function getMidnight10MWindSpeed(): ?float;

    public function getMidnightMslp(): ?int;

    public function getMidnightRelativeHumidity(): ?float;

    public function getMidnightVisibility(): ?int;

    public function getNightLowerBoundMinFeelsLikeTemp(): ?float;

    public function getNightLowerBoundMinTemp(): ?float;

    public function getNightMinFeelsLikeTemp(): ?float;

    public function getNightMinScreenTemperature(): ?float;

    public function getNightProbabilityOfHail(): ?int;

    public function getNightProbabilityOfHeavyRain(): ?int;

    public function getNightProbabilityOfHeavySnow(): ?int;

    public function getNightProbabilityOfPrecipitation(): ?int;

    public function getNightProbabilityOfRain(): ?int;

    public function getNightProbabilityOfSferics(): ?int;

    public function getNightProbabilityOfSnow(): ?int;

    public function getNightSignificantWeatherCode(): ?WeatherType;

    public function getNightUpperBoundMinFeelsLikeTemp(): ?float;

    public function getNightUpperBoundMinTemp(): ?float;

    public function setDayLowerBoundMaxFeelsLikeTemp(?float $value): self;

    public function setDayLowerBoundMaxTemp(?float $value): self;

    public function setDayMaxFeelsLikeTemp(?float $value): self;

    public function setDayMaxScreenTemperature(?float $value): self;

    public function setDayProbabilityOfHail(?int $value): self;

    public function setDayProbabilityOfHeavyRain(?int $value): self;

    public function setDayProbabilityOfHeavySnow(?int $value): self;

    public function setDayProbabilityOfPrecipitation(?int $value): self;

    public function setDayProbabilityOfRain(?int $value): self;

    public function setDayProbabilityOfSferics(?int $value): self;

    public function setDayProbabilityOfSnow(?int $value): self;

    public function setDaySignificantWeatherCode(?WeatherType $value): self;

    public function setDayUpperBoundMaxFeelsLikeTemp(?float $value): self;

    public function setDayUpperBoundMaxTemp(?float $value): self;

    public function setMaxUvIndex(?int $value): self;

    public function setMidday10MWindDirection(?int $value): self;

    public function setMidday10MWindGust(?float $value): self;

    public function setMidday10MWindSpeed(?float $value): self;

    public function setMiddayMslp(?int $value): self;

    public function setMiddayRelativeHumidity(?float $value): self;

    public function setMiddayVisibility(?int $value): self;

    public function setMidnight10MWindDirection(?int $value): self;

    public function setMidnight10MWindGust(?float $value): self;

    public function setMidnight10MWindSpeed(?float $value): self;

    public function setMidnightMslp(?int $value): self;

    public function setMidnightRelativeHumidity(?float $value): self;

    public function setMidnightVisibility(?int $value): self;

    public function setNightLowerBoundMinFeelsLikeTemp(?float $value): self;

    public function setNightLowerBoundMinTemp(?float $value): self;

    public function setNightMinFeelsLikeTemp(?float $value): self;

    public function setNightMinScreenTemperature(?float $value): self;

    public function setNightProbabilityOfHail(?int $value): self;

    public function setNightProbabilityOfHeavyRain(?int $value): self;

    public function setNightProbabilityOfHeavySnow(?int $value): self;

    public function setNightProbabilityOfPrecipitation(?int $value): self;

    public function setNightProbabilityOfRain(?int $value): self;

    public function setNightProbabilityOfSferics(?int $value): self;

    public function setNightProbabilityOfSnow(?int $value): self;

    public function setNightSignificantWeatherCode(?WeatherType $value): self;

    public function setNightUpperBoundMinFeelsLikeTemp(?float $value): self;

    public function setNightUpperBoundMinTemp(?float $value): self;

    public function setTime(int $value): self;
}
