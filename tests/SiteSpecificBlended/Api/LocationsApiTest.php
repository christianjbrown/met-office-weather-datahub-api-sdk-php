<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LocationInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(LocationsApi::class)]
#[UsesClass(ApiKey::class)]
final class LocationsApiTest extends TestCase
{
    /**
     * @param array<string, string> $expectedQuery
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetCoverageCases')]
    public function testGetCoverage(array $expectedQuery, ?string $parameterName, ?string $datetime): void
    {
        $responseData = ['type' => 'CoverageCollection'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationsApiInterface::API_URL_COVERAGE_SPRINTF, 'improver-percentiles-spot-global', rawurlencode('00000046')),
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

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'));

        self::assertSame($coverageCollection, $api->getCoverage('improver-percentiles-spot-global', '00000046', $parameterName, $datetime));
    }

    /**
     * @return iterable<string, array{array<string, string>, ?string, ?string}>
     */
    public static function provideGetCoverageCases(): iterable
    {
        yield 'noParams' => [[], null, null];
        yield 'parameterNameOnly' => [[LocationsApiInterface::QUERY_KEY_PARAMETER_NAME => 'feels_like_temperature'], 'feels_like_temperature', null];
        yield 'datetimeOnly' => [[LocationsApiInterface::QUERY_KEY_DATETIME => '2024-03-08T08:00:00Z'], null, '2024-03-08T08:00:00Z'];
        yield 'bothParams' => [
            [
                LocationsApiInterface::QUERY_KEY_PARAMETER_NAME => 'feels_like_temperature',
                LocationsApiInterface::QUERY_KEY_DATETIME => '2024-03-08T08:00:00Z',
            ],
            'feels_like_temperature',
            '2024-03-08T08:00:00Z',
        ];
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocations(): void
    {
        $featuresData = [['id' => '00000046']];
        $data = [LocationsApiInterface::KEY_FEATURES => $featuresData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationsApiInterface::API_URL_LOCATIONS_SPRINTF, 'improver-percentiles-spot-global'),
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

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'));

        self::assertSame($locations, $api->getLocations('improver-percentiles-spot-global'));
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

        $api = new LocationsApi($requestSender, $locationsTransformer, $coverageCollectionTransformer, new ApiKey('test-api-key'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationsApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationsApiInterface::KEY_FEATURES));

        $api->getLocations('improver-percentiles-spot-global');
    }
}
