<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

final class ThreeHourlyForecastTimeStep implements ThreeHourlyForecastTimeStepInterface
{
    private ?float $feelsLikeTemp = null;
    private ?float $max10mWindGust = null;
    private ?float $maxScreenAirTemp = null;
    private ?float $minScreenAirTemp = null;
    private ?int $mslp = null;
    private ?int $probOfHail = null;
    private ?int $probOfHeavyRain = null;
    private ?int $probOfHeavySnow = null;
    private ?int $probOfPrecipitation = null;
    private ?int $probOfRain = null;
    private ?int $probOfSferics = null;
    private ?int $probOfSnow = null;
    private ?float $screenRelativeHumidity = null;
    private ?WeatherType $significantWeatherCode = null;
    private int $time;
    private ?float $totalPrecipAmount = null;
    private ?float $totalSnowAmount = null;
    private ?int $uvIndex = null;
    private ?int $visibility = null;
    private ?int $windDirectionFrom10m = null;
    private ?float $windGustSpeed10m = null;
    private ?float $windSpeed10m = null;

    public function __construct(int $time)
    {
        $this->time = $time;
    }

    public function getFeelsLikeTemp(): ?float
    {
        return $this->feelsLikeTemp;
    }

    public function getMax10mWindGust(): ?float
    {
        return $this->max10mWindGust;
    }

    public function getMaxScreenAirTemp(): ?float
    {
        return $this->maxScreenAirTemp;
    }

    public function getMinScreenAirTemp(): ?float
    {
        return $this->minScreenAirTemp;
    }

    public function getMslp(): ?int
    {
        return $this->mslp;
    }

    public function getProbOfHail(): ?int
    {
        return $this->probOfHail;
    }

    public function getProbOfHeavyRain(): ?int
    {
        return $this->probOfHeavyRain;
    }

    public function getProbOfHeavySnow(): ?int
    {
        return $this->probOfHeavySnow;
    }

    public function getProbOfPrecipitation(): ?int
    {
        return $this->probOfPrecipitation;
    }

    public function getProbOfRain(): ?int
    {
        return $this->probOfRain;
    }

    public function getProbOfSferics(): ?int
    {
        return $this->probOfSferics;
    }

    public function getProbOfSnow(): ?int
    {
        return $this->probOfSnow;
    }

    public function getScreenRelativeHumidity(): ?float
    {
        return $this->screenRelativeHumidity;
    }

    public function getSignificantWeatherCode(): ?WeatherType
    {
        return $this->significantWeatherCode;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getTotalPrecipAmount(): ?float
    {
        return $this->totalPrecipAmount;
    }

    public function getTotalSnowAmount(): ?float
    {
        return $this->totalSnowAmount;
    }

    public function getUvIndex(): ?int
    {
        return $this->uvIndex;
    }

    public function getVisibility(): ?int
    {
        return $this->visibility;
    }

    public function getWindDirectionFrom10m(): ?int
    {
        return $this->windDirectionFrom10m;
    }

    public function getWindGustSpeed10m(): ?float
    {
        return $this->windGustSpeed10m;
    }

    public function getWindSpeed10m(): ?float
    {
        return $this->windSpeed10m;
    }

    public function setFeelsLikeTemp(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->feelsLikeTemp = $value;

        return $this;
    }

    public function setMax10mWindGust(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->max10mWindGust = $value;

        return $this;
    }

    public function setMaxScreenAirTemp(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->maxScreenAirTemp = $value;

        return $this;
    }

    public function setMinScreenAirTemp(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->minScreenAirTemp = $value;

        return $this;
    }

    public function setMslp(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->mslp = $value;

        return $this;
    }

    public function setProbOfHail(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfHail = $value;

        return $this;
    }

    public function setProbOfHeavyRain(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfHeavyRain = $value;

        return $this;
    }

    public function setProbOfHeavySnow(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfHeavySnow = $value;

        return $this;
    }

    public function setProbOfPrecipitation(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfPrecipitation = $value;

        return $this;
    }

    public function setProbOfRain(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfRain = $value;

        return $this;
    }

    public function setProbOfSferics(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfSferics = $value;

        return $this;
    }

    public function setProbOfSnow(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->probOfSnow = $value;

        return $this;
    }

    public function setScreenRelativeHumidity(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->screenRelativeHumidity = $value;

        return $this;
    }

    public function setSignificantWeatherCode(?WeatherType $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->significantWeatherCode = $value;

        return $this;
    }

    public function setTime(int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->time = $value;

        return $this;
    }

    public function setTotalPrecipAmount(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->totalPrecipAmount = $value;

        return $this;
    }

    public function setTotalSnowAmount(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->totalSnowAmount = $value;

        return $this;
    }

    public function setUvIndex(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->uvIndex = $value;

        return $this;
    }

    public function setVisibility(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->visibility = $value;

        return $this;
    }

    public function setWindDirectionFrom10m(?int $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->windDirectionFrom10m = $value;

        return $this;
    }

    public function setWindGustSpeed10m(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->windGustSpeed10m = $value;

        return $this;
    }

    public function setWindSpeed10m(?float $value): ThreeHourlyForecastTimeStepInterface
    {
        $this->windSpeed10m = $value;

        return $this;
    }
}
