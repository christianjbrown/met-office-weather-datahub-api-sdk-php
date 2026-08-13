<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\ApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DataQuery::class)]
final class DataQueryTest extends TestCase
{
    public function testDefaults(): void
    {
        $query = new DataQuery();

        self::assertNull($query->getDatetime());
        self::assertSame([], $query->getParameterNames());
        self::assertSame([], $query->getPercentiles());
        self::assertSame([], $query->toQuery());
    }

    public function testGetters(): void
    {
        $query = new DataQuery(['airTemperature1p5m'], ['50'], '2026-08-13T00:00:00Z');

        self::assertSame('2026-08-13T00:00:00Z', $query->getDatetime());
        self::assertSame(['airTemperature1p5m'], $query->getParameterNames());
        self::assertSame(['50'], $query->getPercentiles());
    }

    /**
     * @param array<int, string>    $parameterNames
     * @param array<int, string>    $percentiles
     * @param array<string, string> $expected
     */
    #[DataProvider('provideToQueryCases')]
    public function testToQuery(array $parameterNames, array $percentiles, array $expected, ?string $datetime): void
    {
        self::assertSame($expected, (new DataQuery($parameterNames, $percentiles, $datetime))->toQuery());
    }

    /**
     * @return iterable<string, array{array<int, string>, array<int, string>, array<string, string>, ?string}>
     */
    public static function provideToQueryCases(): iterable
    {
        yield 'none' => [[], [], [], null];
        yield 'parameterNamesOnly' => [
            ['airTemperature1p5m'],
            [],
            [ApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m'],
            null,
        ];
        yield 'percentilesOnly' => [
            [],
            ['50'],
            [ApiInterface::QUERY_KEY_PERCENTILES => '50'],
            null,
        ];
        yield 'datetimeOnly' => [
            [],
            [],
            [ApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z'],
            '2026-08-13T00:00:00Z',
        ];
        yield 'parameterNamesAndPercentiles' => [
            ['airTemperature1p5m'],
            ['50'],
            [
                ApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m',
                ApiInterface::QUERY_KEY_PERCENTILES => '50',
            ],
            null,
        ];
        yield 'parameterNamesAndDatetime' => [
            ['airTemperature1p5m'],
            [],
            [
                ApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m',
                ApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z',
            ],
            '2026-08-13T00:00:00Z',
        ];
        yield 'percentilesAndDatetime' => [
            [],
            ['50'],
            [
                ApiInterface::QUERY_KEY_PERCENTILES => '50',
                ApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z',
            ],
            '2026-08-13T00:00:00Z',
        ];
        yield 'allJoined' => [
            ['airTemperature1p5m', 'airTemperature1p5mMaximumPt12h'],
            ['50', '90'],
            [
                ApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m,airTemperature1p5mMaximumPt12h',
                ApiInterface::QUERY_KEY_PERCENTILES => '50,90',
                ApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
            ],
            '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
        ];
    }
}
