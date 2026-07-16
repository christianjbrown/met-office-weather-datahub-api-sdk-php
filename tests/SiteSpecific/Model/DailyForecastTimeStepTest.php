<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\SiteSpecific\Model\DailyForecastTimeStep;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DailyForecastTimeStep::class)]
final class DailyForecastTimeStepTest extends TestCase
{
    public function test(): void
    {
        $timeStep = new DailyForecastTimeStep(123);
        self::assertSame(123, $timeStep->getTime());
        self::assertNull($timeStep->getMidday10MWindSpeed());
        self::assertNull($timeStep->getMidnight10MWindSpeed());
        self::assertNull($timeStep->getMidday10MWindGust());
        self::assertNull($timeStep->getMidnight10MWindGust());
        self::assertNull($timeStep->getMidday10MWindDirection());
        self::assertNull($timeStep->getMidnight10MWindDirection());
        self::assertNull($timeStep->getMiddayVisibility());
        self::assertNull($timeStep->getMidnightVisibility());
        self::assertNull($timeStep->getMiddayRelativeHumidity());
        self::assertNull($timeStep->getMidnightRelativeHumidity());
        self::assertNull($timeStep->getMiddayMslp());
        self::assertNull($timeStep->getMidnightMslp());
        self::assertNull($timeStep->getMaxUvIndex());
        self::assertNull($timeStep->getDaySignificantWeatherCode());
        self::assertNull($timeStep->getNightSignificantWeatherCode());
        self::assertNull($timeStep->getDayMaxScreenTemperature());
        self::assertNull($timeStep->getNightMinScreenTemperature());
        self::assertNull($timeStep->getDayUpperBoundMaxTemp());
        self::assertNull($timeStep->getDayLowerBoundMaxTemp());
        self::assertNull($timeStep->getNightUpperBoundMinTemp());
        self::assertNull($timeStep->getNightLowerBoundMinTemp());
        self::assertNull($timeStep->getDayMaxFeelsLikeTemp());
        self::assertNull($timeStep->getNightMinFeelsLikeTemp());
        self::assertNull($timeStep->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertNull($timeStep->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertNull($timeStep->getNightUpperBoundMinFeelsLikeTemp());
        self::assertNull($timeStep->getNightLowerBoundMinFeelsLikeTemp());
        self::assertNull($timeStep->getDayProbabilityOfPrecipitation());
        self::assertNull($timeStep->getNightProbabilityOfPrecipitation());
        self::assertNull($timeStep->getDayProbabilityOfRain());
        self::assertNull($timeStep->getNightProbabilityOfRain());
        self::assertNull($timeStep->getDayProbabilityOfHeavyRain());
        self::assertNull($timeStep->getNightProbabilityOfHeavyRain());
        self::assertNull($timeStep->getDayProbabilityOfSnow());
        self::assertNull($timeStep->getNightProbabilityOfSnow());
        self::assertNull($timeStep->getDayProbabilityOfHeavySnow());
        self::assertNull($timeStep->getNightProbabilityOfHeavySnow());
        self::assertNull($timeStep->getDayProbabilityOfHail());
        self::assertNull($timeStep->getNightProbabilityOfHail());
        self::assertNull($timeStep->getDayProbabilityOfSferics());
        self::assertNull($timeStep->getNightProbabilityOfSferics());

        self::assertSame($timeStep, $timeStep->setTime(456));
        self::assertSame($timeStep, $timeStep->setMidday10MWindSpeed(1.5));
        self::assertSame($timeStep, $timeStep->setMidnight10MWindSpeed(2.5));
        self::assertSame($timeStep, $timeStep->setMidday10MWindGust(3.5));
        self::assertSame($timeStep, $timeStep->setMidnight10MWindGust(4.5));
        self::assertSame($timeStep, $timeStep->setMidday10MWindDirection(104));
        self::assertSame($timeStep, $timeStep->setMidnight10MWindDirection(105));
        self::assertSame($timeStep, $timeStep->setMiddayVisibility(106));
        self::assertSame($timeStep, $timeStep->setMidnightVisibility(107));
        self::assertSame($timeStep, $timeStep->setMiddayRelativeHumidity(9.5));
        self::assertSame($timeStep, $timeStep->setMidnightRelativeHumidity(10.5));
        self::assertSame($timeStep, $timeStep->setMiddayMslp(110));
        self::assertSame($timeStep, $timeStep->setMidnightMslp(111));
        self::assertSame($timeStep, $timeStep->setMaxUvIndex(112));
        self::assertSame($timeStep, $timeStep->setDaySignificantWeatherCode(WeatherType::SUNNY_DAY));
        self::assertSame($timeStep, $timeStep->setNightSignificantWeatherCode(WeatherType::PARTLY_CLOUDY_DAY));
        self::assertSame($timeStep, $timeStep->setDayMaxScreenTemperature(16.5));
        self::assertSame($timeStep, $timeStep->setNightMinScreenTemperature(17.5));
        self::assertSame($timeStep, $timeStep->setDayUpperBoundMaxTemp(18.5));
        self::assertSame($timeStep, $timeStep->setDayLowerBoundMaxTemp(19.5));
        self::assertSame($timeStep, $timeStep->setNightUpperBoundMinTemp(20.5));
        self::assertSame($timeStep, $timeStep->setNightLowerBoundMinTemp(21.5));
        self::assertSame($timeStep, $timeStep->setDayMaxFeelsLikeTemp(22.5));
        self::assertSame($timeStep, $timeStep->setNightMinFeelsLikeTemp(23.5));
        self::assertSame($timeStep, $timeStep->setDayUpperBoundMaxFeelsLikeTemp(24.5));
        self::assertSame($timeStep, $timeStep->setDayLowerBoundMaxFeelsLikeTemp(25.5));
        self::assertSame($timeStep, $timeStep->setNightUpperBoundMinFeelsLikeTemp(26.5));
        self::assertSame($timeStep, $timeStep->setNightLowerBoundMinFeelsLikeTemp(27.5));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfPrecipitation(127));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfPrecipitation(128));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfRain(129));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfRain(130));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfHeavyRain(131));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfHeavyRain(132));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfSnow(133));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfSnow(134));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfHeavySnow(135));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfHeavySnow(136));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfHail(137));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfHail(138));
        self::assertSame($timeStep, $timeStep->setDayProbabilityOfSferics(139));
        self::assertSame($timeStep, $timeStep->setNightProbabilityOfSferics(140));

        self::assertSame(456, $timeStep->getTime());
        self::assertSame(1.5, $timeStep->getMidday10MWindSpeed());
        self::assertSame(2.5, $timeStep->getMidnight10MWindSpeed());
        self::assertSame(3.5, $timeStep->getMidday10MWindGust());
        self::assertSame(4.5, $timeStep->getMidnight10MWindGust());
        self::assertSame(104, $timeStep->getMidday10MWindDirection());
        self::assertSame(105, $timeStep->getMidnight10MWindDirection());
        self::assertSame(106, $timeStep->getMiddayVisibility());
        self::assertSame(107, $timeStep->getMidnightVisibility());
        self::assertSame(9.5, $timeStep->getMiddayRelativeHumidity());
        self::assertSame(10.5, $timeStep->getMidnightRelativeHumidity());
        self::assertSame(110, $timeStep->getMiddayMslp());
        self::assertSame(111, $timeStep->getMidnightMslp());
        self::assertSame(112, $timeStep->getMaxUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $timeStep->getDaySignificantWeatherCode());
        self::assertSame(WeatherType::PARTLY_CLOUDY_DAY, $timeStep->getNightSignificantWeatherCode());
        self::assertSame(16.5, $timeStep->getDayMaxScreenTemperature());
        self::assertSame(17.5, $timeStep->getNightMinScreenTemperature());
        self::assertSame(18.5, $timeStep->getDayUpperBoundMaxTemp());
        self::assertSame(19.5, $timeStep->getDayLowerBoundMaxTemp());
        self::assertSame(20.5, $timeStep->getNightUpperBoundMinTemp());
        self::assertSame(21.5, $timeStep->getNightLowerBoundMinTemp());
        self::assertSame(22.5, $timeStep->getDayMaxFeelsLikeTemp());
        self::assertSame(23.5, $timeStep->getNightMinFeelsLikeTemp());
        self::assertSame(24.5, $timeStep->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertSame(25.5, $timeStep->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertSame(26.5, $timeStep->getNightUpperBoundMinFeelsLikeTemp());
        self::assertSame(27.5, $timeStep->getNightLowerBoundMinFeelsLikeTemp());
        self::assertSame(127, $timeStep->getDayProbabilityOfPrecipitation());
        self::assertSame(128, $timeStep->getNightProbabilityOfPrecipitation());
        self::assertSame(129, $timeStep->getDayProbabilityOfRain());
        self::assertSame(130, $timeStep->getNightProbabilityOfRain());
        self::assertSame(131, $timeStep->getDayProbabilityOfHeavyRain());
        self::assertSame(132, $timeStep->getNightProbabilityOfHeavyRain());
        self::assertSame(133, $timeStep->getDayProbabilityOfSnow());
        self::assertSame(134, $timeStep->getNightProbabilityOfSnow());
        self::assertSame(135, $timeStep->getDayProbabilityOfHeavySnow());
        self::assertSame(136, $timeStep->getNightProbabilityOfHeavySnow());
        self::assertSame(137, $timeStep->getDayProbabilityOfHail());
        self::assertSame(138, $timeStep->getNightProbabilityOfHail());
        self::assertSame(139, $timeStep->getDayProbabilityOfSferics());
        self::assertSame(140, $timeStep->getNightProbabilityOfSferics());
    }
}
