<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Model\ThreeHourlyForecastTimeStep;
use ChristianBrown\MetOffice\Transformer\ThreeHourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\ThreeHourlyForecastTimeStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(ThreeHourlyForecastTimeStep::class)]
#[CoversClass(ThreeHourlyForecastTimeStepTransformer::class)]
final class ThreeHourlyForecastTimeStepTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 1.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 2.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMP => 3.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 4.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 104,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 6.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 7.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 107,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 9.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MSLP => 109,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 110,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 1,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 13.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 14.5,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 114,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_RAIN => 115,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_RAIN => 116,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SNOW => 117,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_SNOW => 118,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HAIL => 119,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SFERICS => 120,
        ];

        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1784203200, $actual->getTime());
        self::assertSame(1.5, $actual->getMaxScreenAirTemp());
        self::assertSame(2.5, $actual->getMinScreenAirTemp());
        self::assertSame(3.5, $actual->getFeelsLikeTemp());
        self::assertSame(4.5, $actual->getWindSpeed10m());
        self::assertSame(104, $actual->getWindDirectionFrom10m());
        self::assertSame(6.5, $actual->getWindGustSpeed10m());
        self::assertSame(7.5, $actual->getMax10mWindGust());
        self::assertSame(107, $actual->getVisibility());
        self::assertSame(9.5, $actual->getScreenRelativeHumidity());
        self::assertSame(109, $actual->getMslp());
        self::assertSame(110, $actual->getUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $actual->getSignificantWeatherCode());
        self::assertSame(13.5, $actual->getTotalPrecipAmount());
        self::assertSame(14.5, $actual->getTotalSnowAmount());
        self::assertSame(114, $actual->getProbOfPrecipitation());
        self::assertSame(115, $actual->getProbOfRain());
        self::assertSame(116, $actual->getProbOfHeavyRain());
        self::assertSame(117, $actual->getProbOfSnow());
        self::assertSame(118, $actual->getProbOfHeavySnow());
        self::assertSame(119, $actual->getProbOfHail());
        self::assertSame(120, $actual->getProbOfSferics());
    }

    public function testTransformAcceptsZeroValues(): void
    {
        $data = [
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMP => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MSLP => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_RAIN => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_RAIN => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SNOW => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_SNOW => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HAIL => 0,
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SFERICS => 0,
        ];

        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0.0, $actual->getMaxScreenAirTemp());
        self::assertSame(0.0, $actual->getMinScreenAirTemp());
        self::assertSame(0.0, $actual->getFeelsLikeTemp());
        self::assertSame(0.0, $actual->getWindSpeed10m());
        self::assertSame(0, $actual->getWindDirectionFrom10m());
        self::assertSame(0.0, $actual->getWindGustSpeed10m());
        self::assertSame(0.0, $actual->getMax10mWindGust());
        self::assertSame(0, $actual->getVisibility());
        self::assertSame(0.0, $actual->getScreenRelativeHumidity());
        self::assertSame(0, $actual->getMslp());
        self::assertSame(0, $actual->getUvIndex());
        self::assertSame(WeatherType::CLEAR_NIGHT, $actual->getSignificantWeatherCode());
        self::assertSame(0.0, $actual->getTotalPrecipAmount());
        self::assertSame(0.0, $actual->getTotalSnowAmount());
        self::assertSame(0, $actual->getProbOfPrecipitation());
        self::assertSame(0, $actual->getProbOfRain());
        self::assertSame(0, $actual->getProbOfHeavyRain());
        self::assertSame(0, $actual->getProbOfSnow());
        self::assertSame(0, $actual->getProbOfHeavySnow());
        self::assertSame(0, $actual->getProbOfHail());
        self::assertSame(0, $actual->getProbOfSferics());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
        ];

        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getMaxScreenAirTemp());
        self::assertNull($actual->getMinScreenAirTemp());
        self::assertNull($actual->getFeelsLikeTemp());
        self::assertNull($actual->getWindSpeed10m());
        self::assertNull($actual->getWindDirectionFrom10m());
        self::assertNull($actual->getWindGustSpeed10m());
        self::assertNull($actual->getMax10mWindGust());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getScreenRelativeHumidity());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getUvIndex());
        self::assertNull($actual->getSignificantWeatherCode());
        self::assertNull($actual->getTotalPrecipAmount());
        self::assertNull($actual->getTotalSnowAmount());
        self::assertNull($actual->getProbOfPrecipitation());
        self::assertNull($actual->getProbOfRain());
        self::assertNull($actual->getProbOfHeavyRain());
        self::assertNull($actual->getProbOfSnow());
        self::assertNull($actual->getProbOfHeavySnow());
        self::assertNull($actual->getProbOfHail());
        self::assertNull($actual->getProbOfSferics());
    }

    public function testTransformSkipsUnknownWeatherCodes(): void
    {
        $data = [
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 99,
        ];

        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getSignificantWeatherCode());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX_SCREEN_AIR_TEMP => 'wrong-maxScreenAirTemp',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MIN_SCREEN_AIR_TEMP => 'wrong-minScreenAirTemp',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_FEELS_LIKE_TEMP => 'wrong-feelsLikeTemp',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_SPEED10M => 'wrong-windSpeed10m',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_DIRECTION_FROM10M => 'wrong-windDirectionFrom10m',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_WIND_GUST_SPEED10M => 'wrong-windGustSpeed10m',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MAX10M_WIND_GUST => 'wrong-max10mWindGust',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_VISIBILITY => 'wrong-visibility',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SCREEN_RELATIVE_HUMIDITY => 'wrong-screenRelativeHumidity',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_MSLP => 'wrong-mslp',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_UV_INDEX => 'wrong-uvIndex',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_SIGNIFICANT_WEATHER_CODE => 'wrong-significantWeatherCode',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_PRECIP_AMOUNT => 'wrong-totalPrecipAmount',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_TOTAL_SNOW_AMOUNT => 'wrong-totalSnowAmount',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_PRECIPITATION => 'wrong-probOfPrecipitation',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_RAIN => 'wrong-probOfRain',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_RAIN => 'wrong-probOfHeavyRain',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SNOW => 'wrong-probOfSnow',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HEAVY_SNOW => 'wrong-probOfHeavySnow',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_HAIL => 'wrong-probOfHail',
            ThreeHourlyForecastTimeStepTransformerInterface::KEY_PROB_OF_SFERICS => 'wrong-probOfSferics',
        ];

        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getMaxScreenAirTemp());
        self::assertNull($actual->getMinScreenAirTemp());
        self::assertNull($actual->getFeelsLikeTemp());
        self::assertNull($actual->getWindSpeed10m());
        self::assertNull($actual->getWindDirectionFrom10m());
        self::assertNull($actual->getWindGustSpeed10m());
        self::assertNull($actual->getMax10mWindGust());
        self::assertNull($actual->getVisibility());
        self::assertNull($actual->getScreenRelativeHumidity());
        self::assertNull($actual->getMslp());
        self::assertNull($actual->getUvIndex());
        self::assertNull($actual->getSignificantWeatherCode());
        self::assertNull($actual->getTotalPrecipAmount());
        self::assertNull($actual->getTotalSnowAmount());
        self::assertNull($actual->getProbOfPrecipitation());
        self::assertNull($actual->getProbOfRain());
        self::assertNull($actual->getProbOfHeavyRain());
        self::assertNull($actual->getProbOfSnow());
        self::assertNull($actual->getProbOfHeavySnow());
        self::assertNull($actual->getProbOfHail());
        self::assertNull($actual->getProbOfSferics());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], ThreeHourlyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => 42], ThreeHourlyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[ThreeHourlyForecastTimeStepTransformerInterface::KEY_TIME => 'test-not-a-timestamp'], ThreeHourlyForecastTimeStepTransformerInterface::UNEXPECTED_TIMESTAMP_SPRINTF, 'test-not-a-timestamp'])]
    public function testTransformUnexpectedData(array $data, string $message, string $field): void
    {
        $transformer = new ThreeHourlyForecastTimeStepTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($message, $field));
        $transformer->transform($data);
    }
}
