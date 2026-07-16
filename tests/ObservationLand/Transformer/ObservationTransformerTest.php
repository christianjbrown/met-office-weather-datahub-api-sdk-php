<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Enums\WindDirection;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\Observation;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Observation::class)]
#[CoversClass(ObservationTransformer::class)]
final class ObservationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
            ObservationTransformerInterface::KEY_TEMPERATURE => 27.65,
            ObservationTransformerInterface::KEY_HUMIDITY => 39,
            ObservationTransformerInterface::KEY_WIND_SPEED => 4.7,
            ObservationTransformerInterface::KEY_WIND_GUST => 8.7,
            ObservationTransformerInterface::KEY_WIND_DIRECTION => 'ENE',
            ObservationTransformerInterface::KEY_WEATHER_CODE => 1,
            ObservationTransformerInterface::KEY_VISIBILITY => 29250.0,
            ObservationTransformerInterface::KEY_MSLP => 1020,
            ObservationTransformerInterface::KEY_PRESSURE_TENDENCY => 'F',
        ];

        $transformer = new ObservationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1784203200, $actual->getDatetime());
        self::assertSame(27.65, $actual->getTemperature());
        self::assertSame(39, $actual->getHumidity());
        self::assertSame(4.7, $actual->getWindSpeed());
        self::assertSame(8.7, $actual->getWindGust());
        self::assertSame(WindDirection::EAST_NORTH_EAST, $actual->getWindDirection());
        self::assertSame(WeatherType::SUNNY_DAY, $actual->getWeatherCode());
        self::assertSame(29250.0, $actual->getVisibility());
        self::assertSame(1020, $actual->getMslp());
        self::assertSame('F', $actual->getPressureTendency());
    }

    public function testTransformAcceptsWholeNumberFloatsAndZeroValues(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
            ObservationTransformerInterface::KEY_TEMPERATURE => 0,
            ObservationTransformerInterface::KEY_HUMIDITY => 0,
            ObservationTransformerInterface::KEY_WIND_SPEED => 0,
            ObservationTransformerInterface::KEY_WIND_GUST => 0,
            ObservationTransformerInterface::KEY_WEATHER_CODE => 0,
            ObservationTransformerInterface::KEY_VISIBILITY => 0,
            ObservationTransformerInterface::KEY_MSLP => 0,
        ];

        $transformer = new ObservationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0.0, $actual->getTemperature());
        self::assertSame(0, $actual->getHumidity());
        self::assertSame(0.0, $actual->getWindSpeed());
        self::assertSame(0.0, $actual->getWindGust());
        self::assertSame(WeatherType::CLEAR_NIGHT, $actual->getWeatherCode());
        self::assertSame(0.0, $actual->getVisibility());
        self::assertSame(0, $actual->getMslp());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
        ];

        $transformer = new ObservationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1784203200, $actual->getDatetime());
        self::assertNull($actual->getTemperature());
        self::assertNull($actual->getHumidity());
        self::assertNull($actual->getWindSpeed());
        self::assertNull($actual->getWindGust());
        self::assertNull($actual->getWindDirection());
        self::assertNull($actual->getWeatherCode());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getPressureTendency());
    }

    public function testTransformSkipsUnknownWeatherCodes(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
            ObservationTransformerInterface::KEY_WEATHER_CODE => 99,
        ];

        $transformer = new ObservationTransformer();

        self::assertNull($transformer->transform($data)->getWeatherCode());
    }

    public function testTransformSkipsUnknownWindDirection(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
            ObservationTransformerInterface::KEY_WIND_DIRECTION => 'not-a-compass-point',
        ];

        $transformer = new ObservationTransformer();

        self::assertNull($transformer->transform($data)->getWindDirection());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            ObservationTransformerInterface::KEY_DATETIME => '2026-07-16T12:00Z',
            ObservationTransformerInterface::KEY_TEMPERATURE => 'wrong-temperature',
            ObservationTransformerInterface::KEY_HUMIDITY => 'wrong-humidity',
            ObservationTransformerInterface::KEY_WIND_SPEED => 'wrong-wind_speed',
            ObservationTransformerInterface::KEY_WIND_GUST => 'wrong-wind_gust',
            ObservationTransformerInterface::KEY_WIND_DIRECTION => 42,
            ObservationTransformerInterface::KEY_WEATHER_CODE => 'wrong-weather_code',
            ObservationTransformerInterface::KEY_VISIBILITY => 'wrong-visibility',
            ObservationTransformerInterface::KEY_MSLP => 'wrong-mslp',
            ObservationTransformerInterface::KEY_PRESSURE_TENDENCY => 42,
        ];

        $transformer = new ObservationTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getTemperature());
        self::assertNull($actual->getHumidity());
        self::assertNull($actual->getWindSpeed());
        self::assertNull($actual->getWindGust());
        self::assertNull($actual->getWindDirection());
        self::assertNull($actual->getWeatherCode());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getPressureTendency());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], ObservationTransformerInterface::UNEXPECTED_STRING_SPRINTF, ObservationTransformerInterface::KEY_DATETIME])]
    #[TestWith([[ObservationTransformerInterface::KEY_DATETIME => 42], ObservationTransformerInterface::UNEXPECTED_STRING_SPRINTF, ObservationTransformerInterface::KEY_DATETIME])]
    #[TestWith([[ObservationTransformerInterface::KEY_DATETIME => 'test-not-a-timestamp'], ObservationTransformerInterface::UNEXPECTED_TIMESTAMP_SPRINTF, 'test-not-a-timestamp'])]
    public function testTransformUnexpectedData(array $data, string $message, string $field): void
    {
        $transformer = new ObservationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($message, $field));
        $transformer->transform($data);
    }
}
