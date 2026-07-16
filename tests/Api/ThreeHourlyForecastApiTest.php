<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Model\ForecastInterface;
use ChristianBrown\MetOffice\Transformer\ForecastTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ThreeHourlyForecastApi::class)]
final class ThreeHourlyForecastApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecast(): void
    {
        $data = [
            ThreeHourlyForecastApiInterface::KEY_FEATURES => [
                [
                    ThreeHourlyForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
                ],
            ],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                ThreeHourlyForecastApiInterface::API_URL,
                [
                    ThreeHourlyForecastApiInterface::QUERY_KEY_LATITUDE => '51.5',
                    ThreeHourlyForecastApiInterface::QUERY_KEY_LONGITUDE => '-0.1',
                    ThreeHourlyForecastApiInterface::QUERY_KEY_DATA_SOURCE => ThreeHourlyForecastApiInterface::QUERY_VALUE_DATA_SOURCE,
                    ThreeHourlyForecastApiInterface::QUERY_KEY_EXCLUDE_PARAMETER_METADATA => ThreeHourlyForecastApiInterface::QUERY_VALUE_TRUE,
                    ThreeHourlyForecastApiInterface::QUERY_KEY_INCLUDE_LOCATION_NAME => ThreeHourlyForecastApiInterface::QUERY_VALUE_TRUE,
                ],
                [
                    ThreeHourlyForecastApiInterface::HEADER_KEY_API_KEY => 'test-api-key',
                ]
            )
            ->willReturn($data);

        $forecast = self::createStub(ForecastInterface::class);

        $forecastTransformer = self::createMock(ForecastTransformerInterface::class);
        $forecastTransformer->method('transform')
            ->with(['test-properties'])
            ->willReturn($forecast);

        $api = new ThreeHourlyForecastApi($requestSender, $forecastTransformer, 'test-api-key');
        $actual = $api->getForecast(51.5, -0.1);

        self::assertSame($forecast, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastCaches(): void
    {
        $data = [
            ThreeHourlyForecastApiInterface::KEY_FEATURES => [
                [
                    ThreeHourlyForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
                ],
            ],
        ];

        $forecast = self::createStub(ForecastInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $forecastTransformer = self::createMock(ForecastTransformerInterface::class);
        $forecastTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-properties'])
            ->willReturn($forecast);

        $api = new ThreeHourlyForecastApi($requestSender, $forecastTransformer, 'test-api-key');

        // Second call for the same coordinates is served from the cache without hitting the API.
        self::assertSame($forecast, $api->getForecast(51.5, -0.1));
        self::assertSame($forecast, $api->getForecast(51.5, -0.1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastSkipsCache(): void
    {
        $data = [
            ThreeHourlyForecastApiInterface::KEY_FEATURES => [
                [
                    ThreeHourlyForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
                ],
            ],
        ];

        $forecast = self::createStub(ForecastInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $forecastTransformer = self::createMock(ForecastTransformerInterface::class);
        $forecastTransformer->method('transform')
            ->with(['test-properties'])
            ->willReturn($forecast);

        $api = new ThreeHourlyForecastApi($requestSender, $forecastTransformer, 'test-api-key');

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($forecast, $api->getForecast(51.5, -0.1));
        self::assertSame($forecast, $api->getForecast(51.5, -0.1, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[], ThreeHourlyForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => 'not-an-array'], ThreeHourlyForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [[]]], ThreeHourlyForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => ['not-an-array']], ThreeHourlyForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [['test-feature-filler']]], ThreeHourlyForecastApiInterface::KEY_PROPERTIES, false])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [[ThreeHourlyForecastApiInterface::KEY_PROPERTIES => 'not-an-array']]], ThreeHourlyForecastApiInterface::KEY_PROPERTIES, false])]
    #[TestWith([[], ThreeHourlyForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => 'not-an-array'], ThreeHourlyForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [[]]], ThreeHourlyForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => ['not-an-array']], ThreeHourlyForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [['test-feature-filler']]], ThreeHourlyForecastApiInterface::KEY_PROPERTIES, true])]
    #[TestWith([[ThreeHourlyForecastApiInterface::KEY_FEATURES => [[ThreeHourlyForecastApiInterface::KEY_PROPERTIES => 'not-an-array']]], ThreeHourlyForecastApiInterface::KEY_PROPERTIES, true])]
    public function testGetForecastUnexpectedResponse(array $data, string $field, bool $skipCache): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->willReturn($data);

        $forecastTransformer = self::createStub(ForecastTransformerInterface::class);

        $api = new ThreeHourlyForecastApi($requestSender, $forecastTransformer, 'test-api-key');

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ThreeHourlyForecastApiInterface::UNEXPECTED_RESPONSE_SPRINTF, $field));
        $api->getForecast(51.5, -0.1, $skipCache);
    }
}
