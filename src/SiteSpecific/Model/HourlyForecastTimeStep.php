<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;

final class HourlyForecastTimeStep implements HourlyForecastTimeStepInterface
{
    private ?float $feelsLikeTemperature = null;
    private ?float $max10mWindGust = null;
    private ?float $maxScreenAirTemp = null;
    private ?float $minScreenAirTemp = null;
    private ?int $mslp = null;
    private ?float $precipitationRate = null;
    private ?int $probOfPrecipitation = null;
    private ?float $screenDewPointTemperature = null;
    private ?float $screenRelativeHumidity = null;
    private ?float $screenTemperature = null;
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

    public function getFeelsLikeTemperature(): ?float
    {
        return $this->feelsLikeTemperature;
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

    public function getPrecipitationRate(): ?float
    {
        return $this->precipitationRate;
    }

    public function getProbOfPrecipitation(): ?int
    {
        return $this->probOfPrecipitation;
    }

    public function getScreenDewPointTemperature(): ?float
    {
        return $this->screenDewPointTemperature;
    }

    public function getScreenRelativeHumidity(): ?float
    {
        return $this->screenRelativeHumidity;
    }

    public function getScreenTemperature(): ?float
    {
        return $this->screenTemperature;
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

    public function setFeelsLikeTemperature(?float $value): HourlyForecastTimeStepInterface
    {
        $this->feelsLikeTemperature = $value;

        return $this;
    }

    public function setMax10mWindGust(?float $value): HourlyForecastTimeStepInterface
    {
        $this->max10mWindGust = $value;

        return $this;
    }

    public function setMaxScreenAirTemp(?float $value): HourlyForecastTimeStepInterface
    {
        $this->maxScreenAirTemp = $value;

        return $this;
    }

    public function setMinScreenAirTemp(?float $value): HourlyForecastTimeStepInterface
    {
        $this->minScreenAirTemp = $value;

        return $this;
    }

    public function setMslp(?int $value): HourlyForecastTimeStepInterface
    {
        $this->mslp = $value;

        return $this;
    }

    public function setPrecipitationRate(?float $value): HourlyForecastTimeStepInterface
    {
        $this->precipitationRate = $value;

        return $this;
    }

    public function setProbOfPrecipitation(?int $value): HourlyForecastTimeStepInterface
    {
        $this->probOfPrecipitation = $value;

        return $this;
    }

    public function setScreenDewPointTemperature(?float $value): HourlyForecastTimeStepInterface
    {
        $this->screenDewPointTemperature = $value;

        return $this;
    }

    public function setScreenRelativeHumidity(?float $value): HourlyForecastTimeStepInterface
    {
        $this->screenRelativeHumidity = $value;

        return $this;
    }

    public function setScreenTemperature(?float $value): HourlyForecastTimeStepInterface
    {
        $this->screenTemperature = $value;

        return $this;
    }

    public function setSignificantWeatherCode(?WeatherType $value): HourlyForecastTimeStepInterface
    {
        $this->significantWeatherCode = $value;

        return $this;
    }

    public function setTime(int $value): HourlyForecastTimeStepInterface
    {
        $this->time = $value;

        return $this;
    }

    public function setTotalPrecipAmount(?float $value): HourlyForecastTimeStepInterface
    {
        $this->totalPrecipAmount = $value;

        return $this;
    }

    public function setTotalSnowAmount(?float $value): HourlyForecastTimeStepInterface
    {
        $this->totalSnowAmount = $value;

        return $this;
    }

    public function setUvIndex(?int $value): HourlyForecastTimeStepInterface
    {
        $this->uvIndex = $value;

        return $this;
    }

    public function setVisibility(?int $value): HourlyForecastTimeStepInterface
    {
        $this->visibility = $value;

        return $this;
    }

    public function setWindDirectionFrom10m(?int $value): HourlyForecastTimeStepInterface
    {
        $this->windDirectionFrom10m = $value;

        return $this;
    }

    public function setWindGustSpeed10m(?float $value): HourlyForecastTimeStepInterface
    {
        $this->windGustSpeed10m = $value;

        return $this;
    }

    public function setWindSpeed10m(?float $value): HourlyForecastTimeStepInterface
    {
        $this->windSpeed10m = $value;

        return $this;
    }
}
