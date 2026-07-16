<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Model\DailyForecastTimeStep;
use ChristianBrown\MetOffice\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\Transformer\DailyForecastTimeStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DailyForecastTimeStep::class)]
#[CoversClass(DailyForecastTimeStepTransformer::class)]
final class DailyForecastTimeStepTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DailyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_SPEED => 1.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_SPEED => 2.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_GUST => 3.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_GUST => 4.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_DIRECTION => 104,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_DIRECTION => 105,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_VISIBILITY => 106,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_VISIBILITY => 107,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_RELATIVE_HUMIDITY => 9.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_RELATIVE_HUMIDITY => 10.5,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_MSLP => 110,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_MSLP => 111,
            DailyForecastTimeStepTransformerInterface::KEY_MAX_UV_INDEX => 112,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_SIGNIFICANT_WEATHER_CODE => 1,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE => 3,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_SCREEN_TEMPERATURE => 16.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_SCREEN_TEMPERATURE => 17.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_TEMP => 18.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_TEMP => 19.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_TEMP => 20.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_TEMP => 21.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_FEELS_LIKE_TEMP => 22.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_FEELS_LIKE_TEMP => 23.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP => 24.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP => 25.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP => 26.5,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP => 27.5,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_PRECIPITATION => 127,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION => 128,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_RAIN => 129,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_RAIN => 130,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN => 131,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN => 132,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SNOW => 133,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SNOW => 134,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW => 135,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW => 136,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HAIL => 137,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HAIL => 138,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SFERICS => 139,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SFERICS => 140,
        ];

        $transformer = new DailyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(1784203200, $actual->getTime());
        self::assertSame(1.5, $actual->getMidday10MWindSpeed());
        self::assertSame(2.5, $actual->getMidnight10MWindSpeed());
        self::assertSame(3.5, $actual->getMidday10MWindGust());
        self::assertSame(4.5, $actual->getMidnight10MWindGust());
        self::assertSame(104, $actual->getMidday10MWindDirection());
        self::assertSame(105, $actual->getMidnight10MWindDirection());
        self::assertSame(106, $actual->getMiddayVisibility());
        self::assertSame(107, $actual->getMidnightVisibility());
        self::assertSame(9.5, $actual->getMiddayRelativeHumidity());
        self::assertSame(10.5, $actual->getMidnightRelativeHumidity());
        self::assertSame(110, $actual->getMiddayMslp());
        self::assertSame(111, $actual->getMidnightMslp());
        self::assertSame(112, $actual->getMaxUvIndex());
        self::assertSame(WeatherType::SUNNY_DAY, $actual->getDaySignificantWeatherCode());
        self::assertSame(WeatherType::PARTLY_CLOUDY_DAY, $actual->getNightSignificantWeatherCode());
        self::assertSame(16.5, $actual->getDayMaxScreenTemperature());
        self::assertSame(17.5, $actual->getNightMinScreenTemperature());
        self::assertSame(18.5, $actual->getDayUpperBoundMaxTemp());
        self::assertSame(19.5, $actual->getDayLowerBoundMaxTemp());
        self::assertSame(20.5, $actual->getNightUpperBoundMinTemp());
        self::assertSame(21.5, $actual->getNightLowerBoundMinTemp());
        self::assertSame(22.5, $actual->getDayMaxFeelsLikeTemp());
        self::assertSame(23.5, $actual->getNightMinFeelsLikeTemp());
        self::assertSame(24.5, $actual->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertSame(25.5, $actual->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertSame(26.5, $actual->getNightUpperBoundMinFeelsLikeTemp());
        self::assertSame(27.5, $actual->getNightLowerBoundMinFeelsLikeTemp());
        self::assertSame(127, $actual->getDayProbabilityOfPrecipitation());
        self::assertSame(128, $actual->getNightProbabilityOfPrecipitation());
        self::assertSame(129, $actual->getDayProbabilityOfRain());
        self::assertSame(130, $actual->getNightProbabilityOfRain());
        self::assertSame(131, $actual->getDayProbabilityOfHeavyRain());
        self::assertSame(132, $actual->getNightProbabilityOfHeavyRain());
        self::assertSame(133, $actual->getDayProbabilityOfSnow());
        self::assertSame(134, $actual->getNightProbabilityOfSnow());
        self::assertSame(135, $actual->getDayProbabilityOfHeavySnow());
        self::assertSame(136, $actual->getNightProbabilityOfHeavySnow());
        self::assertSame(137, $actual->getDayProbabilityOfHail());
        self::assertSame(138, $actual->getNightProbabilityOfHail());
        self::assertSame(139, $actual->getDayProbabilityOfSferics());
        self::assertSame(140, $actual->getNightProbabilityOfSferics());
    }

    public function testTransformAcceptsZeroValues(): void
    {
        $data = [
            DailyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_SPEED => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_SPEED => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_GUST => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_GUST => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_DIRECTION => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_DIRECTION => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_VISIBILITY => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_VISIBILITY => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_RELATIVE_HUMIDITY => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_RELATIVE_HUMIDITY => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_MSLP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_MSLP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_MAX_UV_INDEX => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_SIGNIFICANT_WEATHER_CODE => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_SCREEN_TEMPERATURE => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_SCREEN_TEMPERATURE => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_PRECIPITATION => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_RAIN => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_RAIN => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SNOW => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SNOW => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HAIL => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HAIL => 0,
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SFERICS => 0,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SFERICS => 0,
        ];

        $transformer = new DailyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(0.0, $actual->getMidday10MWindSpeed());
        self::assertSame(0.0, $actual->getMidnight10MWindSpeed());
        self::assertSame(0.0, $actual->getMidday10MWindGust());
        self::assertSame(0.0, $actual->getMidnight10MWindGust());
        self::assertSame(0, $actual->getMidday10MWindDirection());
        self::assertSame(0, $actual->getMidnight10MWindDirection());
        self::assertSame(0, $actual->getMiddayVisibility());
        self::assertSame(0, $actual->getMidnightVisibility());
        self::assertSame(0.0, $actual->getMiddayRelativeHumidity());
        self::assertSame(0.0, $actual->getMidnightRelativeHumidity());
        self::assertSame(0, $actual->getMiddayMslp());
        self::assertSame(0, $actual->getMidnightMslp());
        self::assertSame(0, $actual->getMaxUvIndex());
        self::assertSame(WeatherType::CLEAR_NIGHT, $actual->getDaySignificantWeatherCode());
        self::assertSame(WeatherType::CLEAR_NIGHT, $actual->getNightSignificantWeatherCode());
        self::assertSame(0.0, $actual->getDayMaxScreenTemperature());
        self::assertSame(0.0, $actual->getNightMinScreenTemperature());
        self::assertSame(0.0, $actual->getDayUpperBoundMaxTemp());
        self::assertSame(0.0, $actual->getDayLowerBoundMaxTemp());
        self::assertSame(0.0, $actual->getNightUpperBoundMinTemp());
        self::assertSame(0.0, $actual->getNightLowerBoundMinTemp());
        self::assertSame(0.0, $actual->getDayMaxFeelsLikeTemp());
        self::assertSame(0.0, $actual->getNightMinFeelsLikeTemp());
        self::assertSame(0.0, $actual->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertSame(0.0, $actual->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertSame(0.0, $actual->getNightUpperBoundMinFeelsLikeTemp());
        self::assertSame(0.0, $actual->getNightLowerBoundMinFeelsLikeTemp());
        self::assertSame(0, $actual->getDayProbabilityOfPrecipitation());
        self::assertSame(0, $actual->getNightProbabilityOfPrecipitation());
        self::assertSame(0, $actual->getDayProbabilityOfRain());
        self::assertSame(0, $actual->getNightProbabilityOfRain());
        self::assertSame(0, $actual->getDayProbabilityOfHeavyRain());
        self::assertSame(0, $actual->getNightProbabilityOfHeavyRain());
        self::assertSame(0, $actual->getDayProbabilityOfSnow());
        self::assertSame(0, $actual->getNightProbabilityOfSnow());
        self::assertSame(0, $actual->getDayProbabilityOfHeavySnow());
        self::assertSame(0, $actual->getNightProbabilityOfHeavySnow());
        self::assertSame(0, $actual->getDayProbabilityOfHail());
        self::assertSame(0, $actual->getNightProbabilityOfHail());
        self::assertSame(0, $actual->getDayProbabilityOfSferics());
        self::assertSame(0, $actual->getNightProbabilityOfSferics());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            DailyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
        ];

        $transformer = new DailyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getMidday10MWindSpeed());
        self::assertNull($actual->getMidnight10MWindSpeed());
        self::assertNull($actual->getMidday10MWindGust());
        self::assertNull($actual->getMidnight10MWindGust());
        self::assertNull($actual->getMidday10MWindDirection());
        self::assertNull($actual->getMidnight10MWindDirection());
        self::assertNull($actual->getMiddayVisibility());
        self::assertNull($actual->getMidnightVisibility());
        self::assertNull($actual->getMiddayRelativeHumidity());
        self::assertNull($actual->getMidnightRelativeHumidity());
        self::assertNull($actual->getMiddayMslp());
        self::assertNull($actual->getMidnightMslp());
        self::assertNull($actual->getMaxUvIndex());
        self::assertNull($actual->getDaySignificantWeatherCode());
        self::assertNull($actual->getNightSignificantWeatherCode());
        self::assertNull($actual->getDayMaxScreenTemperature());
        self::assertNull($actual->getNightMinScreenTemperature());
        self::assertNull($actual->getDayUpperBoundMaxTemp());
        self::assertNull($actual->getDayLowerBoundMaxTemp());
        self::assertNull($actual->getNightUpperBoundMinTemp());
        self::assertNull($actual->getNightLowerBoundMinTemp());
        self::assertNull($actual->getDayMaxFeelsLikeTemp());
        self::assertNull($actual->getNightMinFeelsLikeTemp());
        self::assertNull($actual->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertNull($actual->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertNull($actual->getNightUpperBoundMinFeelsLikeTemp());
        self::assertNull($actual->getNightLowerBoundMinFeelsLikeTemp());
        self::assertNull($actual->getDayProbabilityOfPrecipitation());
        self::assertNull($actual->getNightProbabilityOfPrecipitation());
        self::assertNull($actual->getDayProbabilityOfRain());
        self::assertNull($actual->getNightProbabilityOfRain());
        self::assertNull($actual->getDayProbabilityOfHeavyRain());
        self::assertNull($actual->getNightProbabilityOfHeavyRain());
        self::assertNull($actual->getDayProbabilityOfSnow());
        self::assertNull($actual->getNightProbabilityOfSnow());
        self::assertNull($actual->getDayProbabilityOfHeavySnow());
        self::assertNull($actual->getNightProbabilityOfHeavySnow());
        self::assertNull($actual->getDayProbabilityOfHail());
        self::assertNull($actual->getNightProbabilityOfHail());
        self::assertNull($actual->getDayProbabilityOfSferics());
        self::assertNull($actual->getNightProbabilityOfSferics());
    }

    public function testTransformSkipsUnknownWeatherCodes(): void
    {
        $data = [
            DailyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_SIGNIFICANT_WEATHER_CODE => 99,
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE => 99,
        ];

        $transformer = new DailyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getDaySignificantWeatherCode());
        self::assertNull($actual->getNightSignificantWeatherCode());
    }

    public function testTransformSkipsWrongTypedFields(): void
    {
        $data = [
            DailyForecastTimeStepTransformerInterface::KEY_TIME => '2026-07-16T12:00Z',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_SPEED => 'wrong-midday10MWindSpeed',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_SPEED => 'wrong-midnight10MWindSpeed',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_GUST => 'wrong-midday10MWindGust',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_GUST => 'wrong-midnight10MWindGust',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY10_M_WIND_DIRECTION => 'wrong-midday10MWindDirection',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT10_M_WIND_DIRECTION => 'wrong-midnight10MWindDirection',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_VISIBILITY => 'wrong-middayVisibility',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_VISIBILITY => 'wrong-midnightVisibility',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_RELATIVE_HUMIDITY => 'wrong-middayRelativeHumidity',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_RELATIVE_HUMIDITY => 'wrong-midnightRelativeHumidity',
            DailyForecastTimeStepTransformerInterface::KEY_MIDDAY_MSLP => 'wrong-middayMslp',
            DailyForecastTimeStepTransformerInterface::KEY_MIDNIGHT_MSLP => 'wrong-midnightMslp',
            DailyForecastTimeStepTransformerInterface::KEY_MAX_UV_INDEX => 'wrong-maxUvIndex',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_SIGNIFICANT_WEATHER_CODE => 'wrong-daySignificantWeatherCode',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_SIGNIFICANT_WEATHER_CODE => 'wrong-nightSignificantWeatherCode',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_SCREEN_TEMPERATURE => 'wrong-dayMaxScreenTemperature',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_SCREEN_TEMPERATURE => 'wrong-nightMinScreenTemperature',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_TEMP => 'wrong-dayUpperBoundMaxTemp',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_TEMP => 'wrong-dayLowerBoundMaxTemp',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_TEMP => 'wrong-nightUpperBoundMinTemp',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_TEMP => 'wrong-nightLowerBoundMinTemp',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_MAX_FEELS_LIKE_TEMP => 'wrong-dayMaxFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_MIN_FEELS_LIKE_TEMP => 'wrong-nightMinFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_UPPER_BOUND_MAX_FEELS_LIKE_TEMP => 'wrong-dayUpperBoundMaxFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_LOWER_BOUND_MAX_FEELS_LIKE_TEMP => 'wrong-dayLowerBoundMaxFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_UPPER_BOUND_MIN_FEELS_LIKE_TEMP => 'wrong-nightUpperBoundMinFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_LOWER_BOUND_MIN_FEELS_LIKE_TEMP => 'wrong-nightLowerBoundMinFeelsLikeTemp',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_PRECIPITATION => 'wrong-dayProbabilityOfPrecipitation',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_PRECIPITATION => 'wrong-nightProbabilityOfPrecipitation',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_RAIN => 'wrong-dayProbabilityOfRain',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_RAIN => 'wrong-nightProbabilityOfRain',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_RAIN => 'wrong-dayProbabilityOfHeavyRain',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_RAIN => 'wrong-nightProbabilityOfHeavyRain',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SNOW => 'wrong-dayProbabilityOfSnow',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SNOW => 'wrong-nightProbabilityOfSnow',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HEAVY_SNOW => 'wrong-dayProbabilityOfHeavySnow',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HEAVY_SNOW => 'wrong-nightProbabilityOfHeavySnow',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_HAIL => 'wrong-dayProbabilityOfHail',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_HAIL => 'wrong-nightProbabilityOfHail',
            DailyForecastTimeStepTransformerInterface::KEY_DAY_PROBABILITY_OF_SFERICS => 'wrong-dayProbabilityOfSferics',
            DailyForecastTimeStepTransformerInterface::KEY_NIGHT_PROBABILITY_OF_SFERICS => 'wrong-nightProbabilityOfSferics',
        ];

        $transformer = new DailyForecastTimeStepTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getMidday10MWindSpeed());
        self::assertNull($actual->getMidnight10MWindSpeed());
        self::assertNull($actual->getMidday10MWindGust());
        self::assertNull($actual->getMidnight10MWindGust());
        self::assertNull($actual->getMidday10MWindDirection());
        self::assertNull($actual->getMidnight10MWindDirection());
        self::assertNull($actual->getMiddayVisibility());
        self::assertNull($actual->getMidnightVisibility());
        self::assertNull($actual->getMiddayRelativeHumidity());
        self::assertNull($actual->getMidnightRelativeHumidity());
        self::assertNull($actual->getMiddayMslp());
        self::assertNull($actual->getMidnightMslp());
        self::assertNull($actual->getMaxUvIndex());
        self::assertNull($actual->getDaySignificantWeatherCode());
        self::assertNull($actual->getNightSignificantWeatherCode());
        self::assertNull($actual->getDayMaxScreenTemperature());
        self::assertNull($actual->getNightMinScreenTemperature());
        self::assertNull($actual->getDayUpperBoundMaxTemp());
        self::assertNull($actual->getDayLowerBoundMaxTemp());
        self::assertNull($actual->getNightUpperBoundMinTemp());
        self::assertNull($actual->getNightLowerBoundMinTemp());
        self::assertNull($actual->getDayMaxFeelsLikeTemp());
        self::assertNull($actual->getNightMinFeelsLikeTemp());
        self::assertNull($actual->getDayUpperBoundMaxFeelsLikeTemp());
        self::assertNull($actual->getDayLowerBoundMaxFeelsLikeTemp());
        self::assertNull($actual->getNightUpperBoundMinFeelsLikeTemp());
        self::assertNull($actual->getNightLowerBoundMinFeelsLikeTemp());
        self::assertNull($actual->getDayProbabilityOfPrecipitation());
        self::assertNull($actual->getNightProbabilityOfPrecipitation());
        self::assertNull($actual->getDayProbabilityOfRain());
        self::assertNull($actual->getNightProbabilityOfRain());
        self::assertNull($actual->getDayProbabilityOfHeavyRain());
        self::assertNull($actual->getNightProbabilityOfHeavyRain());
        self::assertNull($actual->getDayProbabilityOfSnow());
        self::assertNull($actual->getNightProbabilityOfSnow());
        self::assertNull($actual->getDayProbabilityOfHeavySnow());
        self::assertNull($actual->getNightProbabilityOfHeavySnow());
        self::assertNull($actual->getDayProbabilityOfHail());
        self::assertNull($actual->getNightProbabilityOfHail());
        self::assertNull($actual->getDayProbabilityOfSferics());
        self::assertNull($actual->getNightProbabilityOfSferics());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], DailyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, DailyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[DailyForecastTimeStepTransformerInterface::KEY_TIME => 42], DailyForecastTimeStepTransformerInterface::UNEXPECTED_STRING_SPRINTF, DailyForecastTimeStepTransformerInterface::KEY_TIME])]
    #[TestWith([[DailyForecastTimeStepTransformerInterface::KEY_TIME => 'test-not-a-timestamp'], DailyForecastTimeStepTransformerInterface::UNEXPECTED_TIMESTAMP_SPRINTF, 'test-not-a-timestamp'])]
    public function testTransformUnexpectedData(array $data, string $message, string $field): void
    {
        $transformer = new DailyForecastTimeStepTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf($message, $field));
        $transformer->transform($data);
    }
}
