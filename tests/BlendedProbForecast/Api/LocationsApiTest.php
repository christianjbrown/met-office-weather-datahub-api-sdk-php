<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQuery;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LocationInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(LocationsApi::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(DataQuery::class)]
final class LocationsApiTest extends TestCase
{
    /**
     * @param array<string, string> $expectedQuery
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetLocationCases')]
    public function testGetLocation(array $expectedQuery, ?DataQueryInterface $query): void
    {
        $responseData = ['type' => 'CoverageCollection'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationsApiInterface::API_URL_LOCATION_SPRINTF, 'uk-spot-percentiles', rawurlencode('blended'), rawurlencode('00099139')),
                $expectedQuery,
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    LocationsApiInterface::HEADER_KEY_ACCEPT => LocationsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($responseData);

        $coverageCollection = self::createStub(CoverageCollectionInterface::class);

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::never())->method('transform');

        $coverageCollectionTransformer = self::createMock(CoverageCollectionTransformerInterface::class);
        $coverageCollectionTransformer->expects(self::once())
            ->method('transform')
            ->with($responseData)
            ->willReturn($coverageCollection);

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($coverageCollection, $api->getLocation('uk-spot-percentiles', 'blended', '00099139', $query));
    }

    /**
     * @return iterable<string, array{array<string, string>, ?DataQueryInterface}>
     */
    public static function provideGetLocationCases(): iterable
    {
        yield 'noQuery' => [[], null];
        yield 'emptyQuery' => [[], new DataQuery()];
        yield 'fullQuery' => [
            [
                LocationsApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m,airTemperature1p5mMaximumPt12h',
                LocationsApiInterface::QUERY_KEY_PERCENTILES => '50,90',
                LocationsApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
            ],
            new DataQuery(
                ['airTemperature1p5m', 'airTemperature1p5mMaximumPt12h'],
                ['50', '90'],
                '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
            ),
        ];
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocations(): void
    {
        $featuresData = [['id' => '00099139']];
        $data = [LocationsApiInterface::KEY_FEATURES => $featuresData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationsApiInterface::API_URL_LOCATIONS_SPRINTF, 'uk-spot-percentiles', rawurlencode('blended')),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    LocationsApiInterface::HEADER_KEY_ACCEPT => LocationsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $location = self::createStub(LocationInterface::class);
        $locations = [$location];

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::once())
            ->method('transform')
            ->with($featuresData)
            ->willReturn($locations);

        $coverageCollectionTransformer = self::createMock(CoverageCollectionTransformerInterface::class);
        $coverageCollectionTransformer->expects(self::never())->method('transform');

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($locations, $api->getLocations('uk-spot-percentiles', 'blended'));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[LocationsApiInterface::KEY_FEATURES => 'not-an-array']])]
    public function testGetLocationsThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::never())->method('transform');

        $coverageCollectionTransformer = self::createStub(CoverageCollectionTransformerInterface::class);

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationsApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationsApiInterface::KEY_FEATURES));

        $api->getLocations('uk-spot-percentiles', 'blended');
    }
}
