<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\HourlyForecastTimeStep;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(HourlyForecastTimeStep::class)]
#[CoversClass(HourlyForecastTimeStepTransformer::class)]
final class HourlyForecastTimeStepTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_TEMPERATURE => 1.5,
            HourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 2.5,
            HourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 3.5,
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_DEW_POINT_TEMPERATURE => 4.5,
            HourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMPERATURE => 5.5,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 6.5,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 106,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 8.5,
            HourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 9.5,
            HourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 109,
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 11.5,
            HourlyForecastTimeStepTransformerInterface::KEY_MSLP => 111,
            HourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 112,
            HourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 1,
            HourlyForecastTimeStepTransformerInterface::KEY_PRECIPITATION_RATE => 15.5,
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 16.5,
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 17.5,
            HourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 117,
        ];

        $transformer = new HourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1784203200, $actual->getTime());
        self::assertSame(1.5, $actual->getScreenTemperature());
        self::assertSame(2.5, $actual->getMaxScreenAirTemp());
        self::assertSame(3.5, $actual->getMinScreenAirTemp());
        self::assertSame(4.5, $actual->getScreenDewPointTemperature());
        self::assertSame(5.5, $actual->getFeelsLikeTemperature());
        self::assertSame(6.5, $actual->getWindSpeed10m());
        self::assertSame(106, $actual->getWindDirectionFrom10m());
        self::assertSame(8.5, $actual->getWindGustSpeed10m());
        self::assertSame(9.5, $actual->getMax10mWindGust());
        self::assertSame(109, $actual->getVisibility());
        self::assertSame(11.5, $actual->getScreenRelativeHumidity());
        self::assertSame(111, $actual->getMslp());
        self::assertSame(112, $actual->getUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $actual->getSignificantWeatherCode());
        self::assertSame(15.5, $actual->getPrecipitationRate());
        self::assertSame(16.5, $actual->getTotalPrecipAmount());
        self::assertSame(17.5, $actual->getTotalSnowAmount());
        self::assertSame(117, $actual->getProbOfPrecipitation());
    }

    public function testTransformAcceptsZeroValues(): void
    {
        $data = [
            HourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_TEMPERATURE => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_DEW_POINT_TEMPERATURE => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMPERATURE => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_MSLP => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_PRECIPITATION_RATE => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 0,
            HourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 0,
        ];

        $transformer = new HourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0.0, $actual->getScreenTemperature());
        self::assertSame(0.0, $actual->getMaxScreenAirTemp());
        self::assertSame(0.0, $actual->getMinScreenAirTemp());
        self::assertSame(0.0, $actual->getScreenDewPointTemperature());
        self::assertSame(0.0, $actual->getFeelsLikeTemperature());
        self::assertSame(0.0, $actual->getWindSpeed10m());
        self::assertSame(0, $actual->getWindDirectionFrom10m());
        self::assertSame(0.0, $actual->getWindGustSpeed10m());
        self::assertSame(0.0, $actual->getMax10mWindGust());
        self::assertSame(0, $actual->getVisibility());
        self::assertSame(0.0, $actual->getScreenRelativeHumidity());
        self::assertSame(0, $actual->getMslp());
        self::assertSame(0, $actual->getUvIndex());
        self::assertSame(WeatherType::CLEAR_NIGHT, $actual->getSignificantWeatherCode());
        self::assertSame(0.0, $actual->getPrecipitationRate());
        self::assertSame(0.0, $actual->getTotalPrecipAmount());
        self::assertSame(0.0, $actual->getTotalSnowAmount());
        self::assertSame(0, $actual->getProbOfPrecipitation());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            HourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
        ];

        $transformer = new HourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getScreenTemperature());
        self::assertNull($actual->getMaxScreenAirTemp());
        self::assertNull($actual->getMinScreenAirTemp());
        self::assertNull($actual->getScreenDewPointTemperature());
        self::assertNull($actual->getFeelsLikeTemperature());
        self::assertNull($actual->getWindSpeed10m());
        self::assertNull($actual->getWindDirectionFrom10m());
        self::assertNull($actual->getWindGustSpeed10m());
        self::assertNull($actual->getMax10mWindGust());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getScreenRelativeHumidity());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getUvIndex());
        self::assertNull($actual->getSignificantWeatherCode());
        self::assertNull($actual->getPrecipitationRate());
        self::assertNull($actual->getTotalPrecipAmount());
        self::assertNull($actual->getTotalSnowAmount());
        self::assertNull($actual->getProbOfPrecipitation());
    }

    public function testTransformSkipsUnknownWeatherCodes(): void
    {
        $data = [
            HourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            HourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 99,
        ];

        $transformer = new HourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getSignificantWeatherCode());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            HourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_TEMPERATURE => 'wrong-screenTemperature',
            HourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 'wrong-maxScreenAirTemp',
            HourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 'wrong-minScreenAirTemp',
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_DEW_POINT_TEMPERATURE => 'wrong-screenDewPointTemperature',
            HourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMPERATURE => 'wrong-feelsLikeTemperature',
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 'wrong-windSpeed10m',
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 'wrong-windDirectionFrom10m',
            HourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 'wrong-windGustSpeed10m',
            HourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 'wrong-max10mWindGust',
            HourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 'wrong-visibility',
            HourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 'wrong-screenRelativeHumidity',
            HourlyForecastTimeStepTransformerInterface::KEY_MSLP => 'wrong-mslp',
            HourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 'wrong-uvIndex',
            HourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 'wrong-significantWeatherCode',
            HourlyForecastTimeStepTransformerInterface::KEY_PRECIPITATION_RATE => 'wrong-precipitationRate',
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 'wrong-totalPrecipAmount',
            HourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 'wrong-totalSnowAmount',
            HourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 'wrong-probOfPrecipitation',
        ];

        $transformer = new HourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getScreenTemperature());
        self::assertNull($actual->getMaxScreenAirTemp());
        self::assertNull($actual->getMinScreenAirTemp());
        self::assertNull($actual->getScreenDewPointTemperature());
        self::assertNull($actual->getFeelsLikeTemperature());
        self::assertNull($actual->getWindSpeed10m());
        self::assertNull($actual->getWindDirectionFrom10m());
        self::assertNull($actual->getWindGustSpeed10m());
        self::assertNull($actual->getMax10mWindGust());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getScreenRelativeHumidity());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getUvIndex());
        self::assertNull($actual->getSignificantWeatherCode());
        self::assertNull($actual->getPrecipitationRate());
        self::assertNull($actual->getTotalPrecipAmount());
        self::assertNull($actual->getTotalSnowAmount());
        self::assertNull($actual->getProbOfPrecipitation());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], HourlyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, HourlyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[HourlyForecastTimeStepTransformerInterface::KEY_TIME => 42], HourlyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, HourlyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[HourlyForecastTimeStepTransformerInterface::KEY_TIME => 'test-not-a-timestamp'], HourlyForecastTimeStepTransformerInterface::UNEXPECTED_TIMESTAMP_SPRINTF, 'test-not-a-timestamp'])]
    public function testTransformUnexpectedData(array $data, string $message, string $field): void
    {
        $transformer = new HourlyForecastTimeStepTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($message, $field));
        $transformer->transform($data);
    }
}
