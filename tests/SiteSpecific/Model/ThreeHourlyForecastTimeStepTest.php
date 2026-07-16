<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\SiteSpecific\Model\ThreeHourlyForecastTimeStep;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ThreeHourlyForecastTimeStep::class)]
final class ThreeHourlyForecastTimeStepTest extends TestCase
{
    public function test(): void
    {
        $timeStep = new ThreeHourlyForecastTimeStep(123);
        self::assertSame(123, $timeStep->getTime());
        self::assertNull($timeStep->getMaxScreenAirTemp());
        self::assertNull($timeStep->getMinScreenAirTemp());
        self::assertNull($timeStep->getFeelsLikeTemp());
        self::assertNull($timeStep->getWindSpeed10m());
        self::assertNull($timeStep->getWindDirectionFrom10m());
        self::assertNull($timeStep->getWindGustSpeed10m());
        self::assertNull($timeStep->getMax10mWindGust());
        self::assertNull($timeStep->getVisibility());
        self::assertNull($timeStep->getScreenRelativeHumidity());
        self::assertNull($timeStep->getMslp());
        self::assertNull($timeStep->getUvIndex());
        self::assertNull($timeStep->getSignificantWeatherCode());
        self::assertNull($timeStep->getTotalPrecipAmount());
        self::assertNull($timeStep->getTotalSnowAmount());
        self::assertNull($timeStep->getProbOfPrecipitation());
        self::assertNull($timeStep->getProbOfRain());
        self::assertNull($timeStep->getProbOfHeavyRain());
        self::assertNull($timeStep->getProbOfSnow());
        self::assertNull($timeStep->getProbOfHeavySnow());
        self::assertNull($timeStep->getProbOfHail());
        self::assertNull($timeStep->getProbOfSferics());

        self::assertSame($timeStep, $timeStep->setTime(456));
        self::assertSame($timeStep, $timeStep->setMaxScreenAirTemp(1.5));
        self::assertSame($timeStep, $timeStep->setMinScreenAirTemp(2.5));
        self::assertSame($timeStep, $timeStep->setFeelsLikeTemp(3.5));
        self::assertSame($timeStep, $timeStep->setWindSpeed10m(4.5));
        self::assertSame($timeStep, $timeStep->setWindDirectionFrom10m(104));
        self::assertSame($timeStep, $timeStep->setWindGustSpeed10m(6.5));
        self::assertSame($timeStep, $timeStep->setMax10mWindGust(7.5));
        self::assertSame($timeStep, $timeStep->setVisibility(107));
        self::assertSame($timeStep, $timeStep->setScreenRelativeHumidity(9.5));
        self::assertSame($timeStep, $timeStep->setMslp(109));
        self::assertSame($timeStep, $timeStep->setUvIndex(110));
        self::assertSame($timeStep, $timeStep->setSignificantWeatherCode(WeatherType::SUNNY_DAY));
        self::assertSame($timeStep, $timeStep->setTotalPrecipAmount(13.5));
        self::assertSame($timeStep, $timeStep->setTotalSnowAmount(14.5));
        self::assertSame($timeStep, $timeStep->setProbOfPrecipitation(114));
        self::assertSame($timeStep, $timeStep->setProbOfRain(115));
        self::assertSame($timeStep, $timeStep->setProbOfHeavyRain(116));
        self::assertSame($timeStep, $timeStep->setProbOfSnow(117));
        self::assertSame($timeStep, $timeStep->setProbOfHeavySnow(118));
        self::assertSame($timeStep, $timeStep->setProbOfHail(119));
        self::assertSame($timeStep, $timeStep->setProbOfSferics(120));

        self::assertSame(456, $timeStep->getTime());
        self::assertSame(1.5, $timeStep->getMaxScreenAirTemp());
        self::assertSame(2.5, $timeStep->getMinScreenAirTemp());
        self::assertSame(3.5, $timeStep->getFeelsLikeTemp());
        self::assertSame(4.5, $timeStep->getWindSpeed10m());
        self::assertSame(104, $timeStep->getWindDirectionFrom10m());
        self::assertSame(6.5, $timeStep->getWindGustSpeed10m());
        self::assertSame(7.5, $timeStep->getMax10mWindGust());
        self::assertSame(107, $timeStep->getVisibility());
        self::assertSame(9.5, $timeStep->getScreenRelativeHumidity());
        self::assertSame(109, $timeStep->getMslp());
        self::assertSame(110, $timeStep->getUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $timeStep->getSignificantWeatherCode());
        self::assertSame(13.5, $timeStep->getTotalPrecipAmount());
        self::assertSame(14.5, $timeStep->getTotalSnowAmount());
        self::assertSame(114, $timeStep->getProbOfPrecipitation());
        self::assertSame(115, $timeStep->getProbOfRain());
        self::assertSame(116, $timeStep->getProbOfHeavyRain());
        self::assertSame(117, $timeStep->getProbOfSnow());
        self::assertSame(118, $timeStep->getProbOfHeavySnow());
        self::assertSame(119, $timeStep->getProbOfHail());
        self::assertSame(120, $timeStep->getProbOfSferics());
    }
}
