<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Model\HourlyForecastTimeStep;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HourlyForecastTimeStep::class)]
final class HourlyForecastTimeStepTest extends TestCase
{
    public function test(): void
    {
        $timeStep = new HourlyForecastTimeStep(123);
        self::assertSame(123, $timeStep->getTime());
        self::assertNull($timeStep->getScreenTemperature());
        self::assertNull($timeStep->getMaxScreenAirTemp());
        self::assertNull($timeStep->getMinScreenAirTemp());
        self::assertNull($timeStep->getScreenDewPointTemperature());
        self::assertNull($timeStep->getFeelsLikeTemperature());
        self::assertNull($timeStep->getWindSpeed10m());
        self::assertNull($timeStep->getWindDirectionFrom10m());
        self::assertNull($timeStep->getWindGustSpeed10m());
        self::assertNull($timeStep->getMax10mWindGust());
        self::assertNull($timeStep->getVisibility());
        self::assertNull($timeStep->getScreenRelativeHumidity());
        self::assertNull($timeStep->getMslp());
        self::assertNull($timeStep->getUvIndex());
        self::assertNull($timeStep->getSignificantWeatherCode());
        self::assertNull($timeStep->getPrecipitationRate());
        self::assertNull($timeStep->getTotalPrecipAmount());
        self::assertNull($timeStep->getTotalSnowAmount());
        self::assertNull($timeStep->getProbOfPrecipitation());

        self::assertSame($timeStep, $timeStep->setTime(456));
        self::assertSame($timeStep, $timeStep->setScreenTemperature(1.5));
        self::assertSame($timeStep, $timeStep->setMaxScreenAirTemp(2.5));
        self::assertSame($timeStep, $timeStep->setMinScreenAirTemp(3.5));
        self::assertSame($timeStep, $timeStep->setScreenDewPointTemperature(4.5));
        self::assertSame($timeStep, $timeStep->setFeelsLikeTemperature(5.5));
        self::assertSame($timeStep, $timeStep->setWindSpeed10m(6.5));
        self::assertSame($timeStep, $timeStep->setWindDirectionFrom10m(106));
        self::assertSame($timeStep, $timeStep->setWindGustSpeed10m(8.5));
        self::assertSame($timeStep, $timeStep->setMax10mWindGust(9.5));
        self::assertSame($timeStep, $timeStep->setVisibility(109));
        self::assertSame($timeStep, $timeStep->setScreenRelativeHumidity(11.5));
        self::assertSame($timeStep, $timeStep->setMslp(111));
        self::assertSame($timeStep, $timeStep->setUvIndex(112));
        self::assertSame($timeStep, $timeStep->setSignificantWeatherCode(WeatherType::SUNNY_DAY));
        self::assertSame($timeStep, $timeStep->setPrecipitationRate(15.5));
        self::assertSame($timeStep, $timeStep->setTotalPrecipAmount(16.5));
        self::assertSame($timeStep, $timeStep->setTotalSnowAmount(17.5));
        self::assertSame($timeStep, $timeStep->setProbOfPrecipitation(117));

        self::assertSame(456, $timeStep->getTime());
        self::assertSame(1.5, $timeStep->getScreenTemperature());
        self::assertSame(2.5, $timeStep->getMaxScreenAirTemp());
        self::assertSame(3.5, $timeStep->getMinScreenAirTemp());
        self::assertSame(4.5, $timeStep->getScreenDewPointTemperature());
        self::assertSame(5.5, $timeStep->getFeelsLikeTemperature());
        self::assertSame(6.5, $timeStep->getWindSpeed10m());
        self::assertSame(106, $timeStep->getWindDirectionFrom10m());
        self::assertSame(8.5, $timeStep->getWindGustSpeed10m());
        self::assertSame(9.5, $timeStep->getMax10mWindGust());
        self::assertSame(109, $timeStep->getVisibility());
        self::assertSame(11.5, $timeStep->getScreenRelativeHumidity());
        self::assertSame(111, $timeStep->getMslp());
        self::assertSame(112, $timeStep->getUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $timeStep->getSignificantWeatherCode());
        self::assertSame(15.5, $timeStep->getPrecipitationRate());
        self::assertSame(16.5, $timeStep->getTotalPrecipAmount());
        self::assertSame(17.5, $timeStep->getTotalSnowAmount());
        self::assertSame(117, $timeStep->getProbOfPrecipitation());
    }
}
