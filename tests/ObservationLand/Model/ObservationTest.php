<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Enums\WindDirection;
use ChristianBrown\MetOffice\ObservationLand\Model\Observation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Observation::class)]
final class ObservationTest extends TestCase
{
    public function test(): void
    {
        $observation = new Observation(123);
        self::assertSame(123, $observation->getDatetime());
        self::assertNull($observation->getTemperature());
        self::assertNull($observation->getHumidity());
        self::assertNull($observation->getWindSpeed());
        self::assertNull($observation->getWindGust());
        self::assertNull($observation->getWindDirection());
        self::assertNull($observation->getWeatherCode());
        self::assertNull($observation->getVisibility());
        self::assertNull($observation->getMslp());
        self::assertNull($observation->getPressureTendency());

        self::assertSame($observation, $observation->setDatetime(456));
        self::assertSame($observation, $observation->setTemperature(27.65));
        self::assertSame($observation, $observation->setHumidity(39));
        self::assertSame($observation, $observation->setWindSpeed(4.7));
        self::assertSame($observation, $observation->setWindGust(8.7));
        self::assertSame($observation, $observation->setWindDirection(WindDirection::EAST_NORTH_EAST));
        self::assertSame($observation, $observation->setWeatherCode(WeatherType::SUNNY_DAY));
        self::assertSame($observation, $observation->setVisibility(29250.0));
        self::assertSame($observation, $observation->setMslp(1020));
        self::assertSame($observation, $observation->setPressureTendency('F'));

        self::assertSame(456, $observation->getDatetime());
        self::assertSame(27.65, $observation->getTemperature());
        self::assertSame(39, $observation->getHumidity());
        self::assertSame(4.7, $observation->getWindSpeed());
        self::assertSame(8.7, $observation->getWindGust());
        self::assertSame(WindDirection::EAST_NORTH_EAST, $observation->getWindDirection());
        self::assertSame(WeatherType::SUNNY_DAY, $observation->getWeatherCode());
        self::assertSame(29250.0, $observation->getVisibility());
        self::assertSame(1020, $observation->getMslp());
        self::assertSame('F', $observation->getPressureTendency());
    }
}
