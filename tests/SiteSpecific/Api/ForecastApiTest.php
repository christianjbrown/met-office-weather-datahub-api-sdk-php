<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ForecastApi::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(Coordinates::class)]
final class ForecastApiTest extends TestCase
{
    private const string TEST_API_URL = 'https://test.example/sitespecific/v0/point/forecast';

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecast(): void
    {
        $data = [
            ForecastApiInterface::KEY_FEATURES => [
                [
                    ForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
                ],
            ],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                self::TEST_API_URL,
                [
                    ForecastApiInterface::QUERY_KEY_LATITUDE => '51.5',
                    ForecastApiInterface::QUERY_KEY_LONGITUDE => '-0.1',
                    ForecastApiInterface::QUERY_KEY_DATA_SOURCE => ForecastApiInterface::QUERY_VALUE_DATA_SOURCE,
                    ForecastApiInterface::QUERY_KEY_EXCLUDE_PARAMETER_METADATA => ForecastApiInterface::QUERY_VALUE_TRUE,
                    ForecastApiInterface::QUERY_KEY_INCLUDE_LOCATION_NAME => ForecastApiInterface::QUERY_VALUE_TRUE,
                ],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                ]
            )
            ->willReturn($data);

        $forecast = self::createStub(ForecastInterface::class);

        $forecastTransformer = self::createMock(ForecastTransformerInterface::class);
        $forecastTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-properties'])
            ->willReturn($forecast);

        $api = new ForecastApi($requestSender, $forecastTransformer, new ApiKey('test-api-key'));
        $actual = $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1));

        self::assertSame($forecast, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastCaches(): void
    {
        $data = [
            ForecastApiInterface::KEY_FEATURES => [
                [
                    ForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
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

        $api = new ForecastApi($requestSender, $forecastTransformer, new ApiKey('test-api-key'));

        // Second call for the same coordinates is served from the cache without hitting the API.
        self::assertSame($forecast, $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1)));
        self::assertSame($forecast, $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1)));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastSkipsCache(): void
    {
        $data = [
            ForecastApiInterface::KEY_FEATURES => [
                [
                    ForecastApiInterface::KEY_PROPERTIES => ['test-properties'],
                ],
            ],
        ];

        $forecast = self::createStub(ForecastInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $forecastTransformer = self::createMock(ForecastTransformerInterface::class);
        $forecastTransformer->expects(self::exactly(2))
            ->method('transform')
            ->with(['test-properties'])
            ->willReturn($forecast);

        $api = new ForecastApi($requestSender, $forecastTransformer, new ApiKey('test-api-key'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($forecast, $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1)));
        self::assertSame($forecast, $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1), true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[], ForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => 'not-an-array'], ForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [[]]], ForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => ['not-an-array']], ForecastApiInterface::KEY_FEATURES, false])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [['test-feature-filler']]], ForecastApiInterface::KEY_PROPERTIES, false])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [[ForecastApiInterface::KEY_PROPERTIES => 'not-an-array']]], ForecastApiInterface::KEY_PROPERTIES, false])]
    #[TestWith([[], ForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => 'not-an-array'], ForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [[]]], ForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => ['not-an-array']], ForecastApiInterface::KEY_FEATURES, true])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [['test-feature-filler']]], ForecastApiInterface::KEY_PROPERTIES, true])]
    #[TestWith([[ForecastApiInterface::KEY_FEATURES => [[ForecastApiInterface::KEY_PROPERTIES => 'not-an-array']]], ForecastApiInterface::KEY_PROPERTIES, true])]
    public function testGetForecastUnexpectedResponse(array $data, string $field, bool $skipCache): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->willReturn($data);

        $forecastTransformer = self::createStub(ForecastTransformerInterface::class);

        $api = new ForecastApi($requestSender, $forecastTransformer, new ApiKey('test-api-key'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ForecastApiInterface::UNEXPECTED_RESPONSE_SPRINTF, $field));
        $api->getForecast(self::TEST_API_URL, new Coordinates(51.5, -0.1), $skipCache);
    }
}
