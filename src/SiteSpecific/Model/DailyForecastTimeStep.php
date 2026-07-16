<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

final class DailyForecastTimeStep implements DailyForecastTimeStepInterface
{
    private ?float $dayLowerBoundMaxFeelsLikeTemp = null;
    private ?float $dayLowerBoundMaxTemp = null;
    private ?float $dayMaxFeelsLikeTemp = null;
    private ?float $dayMaxScreenTemperature = null;
    private ?int $dayProbabilityOfHail = null;
    private ?int $dayProbabilityOfHeavyRain = null;
    private ?int $dayProbabilityOfHeavySnow = null;
    private ?int $dayProbabilityOfPrecipitation = null;
    private ?int $dayProbabilityOfRain = null;
    private ?int $dayProbabilityOfSferics = null;
    private ?int $dayProbabilityOfSnow = null;
    private ?WeatherType $daySignificantWeatherCode = null;
    private ?float $dayUpperBoundMaxFeelsLikeTemp = null;
    private ?float $dayUpperBoundMaxTemp = null;
    private ?int $maxUvIndex = null;
    private ?int $midday10MWindDirection = null;
    private ?float $midday10MWindGust = null;
    private ?float $midday10MWindSpeed = null;
    private ?int $middayMslp = null;
    private ?float $middayRelativeHumidity = null;
    private ?int $middayVisibility = null;
    private ?int $midnight10MWindDirection = null;
    private ?float $midnight10MWindGust = null;
    private ?float $midnight10MWindSpeed = null;
    private ?int $midnightMslp = null;
    private ?float $midnightRelativeHumidity = null;
    private ?int $midnightVisibility = null;
    private ?float $nightLowerBoundMinFeelsLikeTemp = null;
    private ?float $nightLowerBoundMinTemp = null;
    private ?float $nightMinFeelsLikeTemp = null;
    private ?float $nightMinScreenTemperature = null;
    private ?int $nightProbabilityOfHail = null;
    private ?int $nightProbabilityOfHeavyRain = null;
    private ?int $nightProbabilityOfHeavySnow = null;
    private ?int $nightProbabilityOfPrecipitation = null;
    private ?int $nightProbabilityOfRain = null;
    private ?int $nightProbabilityOfSferics = null;
    private ?int $nightProbabilityOfSnow = null;
    private ?WeatherType $nightSignificantWeatherCode = null;
    private ?float $nightUpperBoundMinFeelsLikeTemp = null;
    private ?float $nightUpperBoundMinTemp = null;
    private int $time;

    public function __construct(int $time)
    {
        $this->time = $time;
    }

    public function getDayLowerBoundMaxFeelsLikeTemp(): ?float
    {
        return $this->dayLowerBoundMaxFeelsLikeTemp;
    }

    public function getDayLowerBoundMaxTemp(): ?float
    {
        return $this->dayLowerBoundMaxTemp;
    }

    public function getDayMaxFeelsLikeTemp(): ?float
    {
        return $this->dayMaxFeelsLikeTemp;
    }

    public function getDayMaxScreenTemperature(): ?float
    {
        return $this->dayMaxScreenTemperature;
    }

    public function getDayProbabilityOfHail(): ?int
    {
        return $this->dayProbabilityOfHail;
    }

    public function getDayProbabilityOfHeavyRain(): ?int
    {
        return $this->dayProbabilityOfHeavyRain;
    }

    public function getDayProbabilityOfHeavySnow(): ?int
    {
        return $this->dayProbabilityOfHeavySnow;
    }

    public function getDayProbabilityOfPrecipitation(): ?int
    {
        return $this->dayProbabilityOfPrecipitation;
    }

    public function getDayProbabilityOfRain(): ?int
    {
        return $this->dayProbabilityOfRain;
    }

    public function getDayProbabilityOfSferics(): ?int
    {
        return $this->dayProbabilityOfSferics;
    }

    public function getDayProbabilityOfSnow(): ?int
    {
        return $this->dayProbabilityOfSnow;
    }

    public function getDaySignificantWeatherCode(): ?WeatherType
    {
        return $this->daySignificantWeatherCode;
    }

    public function getDayUpperBoundMaxFeelsLikeTemp(): ?float
    {
        return $this->dayUpperBoundMaxFeelsLikeTemp;
    }

    public function getDayUpperBoundMaxTemp(): ?float
    {
        return $this->dayUpperBoundMaxTemp;
    }

    public function getMaxUvIndex(): ?int
    {
        return $this->maxUvIndex;
    }

    public function getMidday10MWindDirection(): ?int
    {
        return $this->midday10MWindDirection;
    }

    public function getMidday10MWindGust(): ?float
    {
        return $this->midday10MWindGust;
    }

    public function getMidday10MWindSpeed(): ?float
    {
        return $this->midday10MWindSpeed;
    }

    public function getMiddayMslp(): ?int
    {
        return $this->middayMslp;
    }

    public function getMiddayRelativeHumidity(): ?float
    {
        return $this->middayRelativeHumidity;
    }

    public function getMiddayVisibility(): ?int
    {
        return $this->middayVisibility;
    }

    public function getMidnight10MWindDirection(): ?int
    {
        return $this->midnight10MWindDirection;
    }

    public function getMidnight10MWindGust(): ?float
    {
        return $this->midnight10MWindGust;
    }

    public function getMidnight10MWindSpeed(): ?float
    {
        return $this->midnight10MWindSpeed;
    }

    public function getMidnightMslp(): ?int
    {
        return $this->midnightMslp;
    }

    public function getMidnightRelativeHumidity(): ?float
    {
        return $this->midnightRelativeHumidity;
    }

    public function getMidnightVisibility(): ?int
    {
        return $this->midnightVisibility;
    }

    public function getNightLowerBoundMinFeelsLikeTemp(): ?float
    {
        return $this->nightLowerBoundMinFeelsLikeTemp;
    }

    public function getNightLowerBoundMinTemp(): ?float
    {
        return $this->nightLowerBoundMinTemp;
    }

    public function getNightMinFeelsLikeTemp(): ?float
    {
        return $this->nightMinFeelsLikeTemp;
    }

    public function getNightMinScreenTemperature(): ?float
    {
        return $this->nightMinScreenTemperature;
    }

    public function getNightProbabilityOfHail(): ?int
    {
        return $this->nightProbabilityOfHail;
    }

    public function getNightProbabilityOfHeavyRain(): ?int
    {
        return $this->nightProbabilityOfHeavyRain;
    }

    public function getNightProbabilityOfHeavySnow(): ?int
    {
        return $this->nightProbabilityOfHeavySnow;
    }

    public function getNightProbabilityOfPrecipitation(): ?int
    {
        return $this->nightProbabilityOfPrecipitation;
    }

    public function getNightProbabilityOfRain(): ?int
    {
        return $this->nightProbabilityOfRain;
    }

    public function getNightProbabilityOfSferics(): ?int
    {
        return $this->nightProbabilityOfSferics;
    }

    public function getNightProbabilityOfSnow(): ?int
    {
        return $this->nightProbabilityOfSnow;
    }

    public function getNightSignificantWeatherCode(): ?WeatherType
    {
        return $this->nightSignificantWeatherCode;
    }

    public function getNightUpperBoundMinFeelsLikeTemp(): ?float
    {
        return $this->nightUpperBoundMinFeelsLikeTemp;
    }

    public function getNightUpperBoundMinTemp(): ?float
    {
        return $this->nightUpperBoundMinTemp;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function setDayLowerBoundMaxFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayLowerBoundMaxFeelsLikeTemp = $value;

        return $this;
    }

    public function setDayLowerBoundMaxTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayLowerBoundMaxTemp = $value;

        return $this;
    }

    public function setDayMaxFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayMaxFeelsLikeTemp = $value;

        return $this;
    }

    public function setDayMaxScreenTemperature(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayMaxScreenTemperature = $value;

        return $this;
    }

    public function setDayProbabilityOfHail(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfHail = $value;

        return $this;
    }

    public function setDayProbabilityOfHeavyRain(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfHeavyRain = $value;

        return $this;
    }

    public function setDayProbabilityOfHeavySnow(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfHeavySnow = $value;

        return $this;
    }

    public function setDayProbabilityOfPrecipitation(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfPrecipitation = $value;

        return $this;
    }

    public function setDayProbabilityOfRain(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfRain = $value;

        return $this;
    }

    public function setDayProbabilityOfSferics(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfSferics = $value;

        return $this;
    }

    public function setDayProbabilityOfSnow(?int $value): DailyForecastTimeStepInterface
    {
        $this->dayProbabilityOfSnow = $value;

        return $this;
    }

    public function setDaySignificantWeatherCode(?WeatherType $value): DailyForecastTimeStepInterface
    {
        $this->daySignificantWeatherCode = $value;

        return $this;
    }

    public function setDayUpperBoundMaxFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayUpperBoundMaxFeelsLikeTemp = $value;

        return $this;
    }

    public function setDayUpperBoundMaxTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->dayUpperBoundMaxTemp = $value;

        return $this;
    }

    public function setMaxUvIndex(?int $value): DailyForecastTimeStepInterface
    {
        $this->maxUvIndex = $value;

        return $this;
    }

    public function setMidday10MWindDirection(?int $value): DailyForecastTimeStepInterface
    {
        $this->midday10MWindDirection = $value;

        return $this;
    }

    public function setMidday10MWindGust(?float $value): DailyForecastTimeStepInterface
    {
        $this->midday10MWindGust = $value;

        return $this;
    }

    public function setMidday10MWindSpeed(?float $value): DailyForecastTimeStepInterface
    {
        $this->midday10MWindSpeed = $value;

        return $this;
    }

    public function setMiddayMslp(?int $value): DailyForecastTimeStepInterface
    {
        $this->middayMslp = $value;

        return $this;
    }

    public function setMiddayRelativeHumidity(?float $value): DailyForecastTimeStepInterface
    {
        $this->middayRelativeHumidity = $value;

        return $this;
    }

    public function setMiddayVisibility(?int $value): DailyForecastTimeStepInterface
    {
        $this->middayVisibility = $value;

        return $this;
    }

    public function setMidnight10MWindDirection(?int $value): DailyForecastTimeStepInterface
    {
        $this->midnight10MWindDirection = $value;

        return $this;
    }

    public function setMidnight10MWindGust(?float $value): DailyForecastTimeStepInterface
    {
        $this->midnight10MWindGust = $value;

        return $this;
    }

    public function setMidnight10MWindSpeed(?float $value): DailyForecastTimeStepInterface
    {
        $this->midnight10MWindSpeed = $value;

        return $this;
    }

    public function setMidnightMslp(?int $value): DailyForecastTimeStepInterface
    {
        $this->midnightMslp = $value;

        return $this;
    }

    public function setMidnightRelativeHumidity(?float $value): DailyForecastTimeStepInterface
    {
        $this->midnightRelativeHumidity = $value;

        return $this;
    }

    public function setMidnightVisibility(?int $value): DailyForecastTimeStepInterface
    {
        $this->midnightVisibility = $value;

        return $this;
    }

    public function setNightLowerBoundMinFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightLowerBoundMinFeelsLikeTemp = $value;

        return $this;
    }

    public function setNightLowerBoundMinTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightLowerBoundMinTemp = $value;

        return $this;
    }

    public function setNightMinFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightMinFeelsLikeTemp = $value;

        return $this;
    }

    public function setNightMinScreenTemperature(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightMinScreenTemperature = $value;

        return $this;
    }

    public function setNightProbabilityOfHail(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfHail = $value;

        return $this;
    }

    public function setNightProbabilityOfHeavyRain(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfHeavyRain = $value;

        return $this;
    }

    public function setNightProbabilityOfHeavySnow(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfHeavySnow = $value;

        return $this;
    }

    public function setNightProbabilityOfPrecipitation(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfPrecipitation = $value;

        return $this;
    }

    public function setNightProbabilityOfRain(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfRain = $value;

        return $this;
    }

    public function setNightProbabilityOfSferics(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfSferics = $value;

        return $this;
    }

    public function setNightProbabilityOfSnow(?int $value): DailyForecastTimeStepInterface
    {
        $this->nightProbabilityOfSnow = $value;

        return $this;
    }

    public function setNightSignificantWeatherCode(?WeatherType $value): DailyForecastTimeStepInterface
    {
        $this->nightSignificantWeatherCode = $value;

        return $this;
    }

    public function setNightUpperBoundMinFeelsLikeTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightUpperBoundMinFeelsLikeTemp = $value;

        return $this;
    }

    public function setNightUpperBoundMinTemp(?float $value): DailyForecastTimeStepInterface
    {
        $this->nightUpperBoundMinTemp = $value;

        return $this;
    }

    public function setTime(int $value): DailyForecastTimeStepInterface
    {
        $this->time = $value;

        return $this;
    }
}
