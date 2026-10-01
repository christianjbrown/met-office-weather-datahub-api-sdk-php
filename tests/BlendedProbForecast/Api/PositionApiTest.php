<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQuery;
use ChristianBrown\MetOffice\BlendedProbForecast\DataQueryInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(PositionApi::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(Coordinates::class)]
#[UsesClass(DataQuery::class)]
final class PositionApiTest extends TestCase
{
    /**
     * @param array<string, string> $expectedQuery
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetPositionCases')]
    public function testGetPosition(array $expectedQuery, ?DataQueryInterface $query): void
    {
        $responseData = ['type' => 'CoverageCollection'];

        $requestSender = self::createMock(JsonReadApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(PositionApiInterface::API_URL_POSITION_SPRINTF, 'uk-spot-percentiles', rawurlencode('blended')),
                $expectedQuery,
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    PositionApiInterface::HEADER_KEY_ACCEPT => PositionApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($responseData);

        $coverageCollection = self::createStub(CoverageCollectionInterface::class);

        $coverageCollectionTransformer = self::createMock(CoverageCollectionTransformerInterface::class);
        $coverageCollectionTransformer->expects(self::once())
            ->method('transform')
            ->with($responseData)
            ->willReturn($coverageCollection);

        $api = new PositionApi($requestSender, $coverageCollectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($coverageCollection, $api->getPosition('uk-spot-percentiles', 'blended', new Coordinates(51.55, -0.18), $query));
    }

    /**
     * @return iterable<string, array{array<string, string>, ?DataQueryInterface}>
     */
    public static function provideGetPositionCases(): iterable
    {
        // The WKT is POINT(longitude latitude) — longitude first.
        yield 'noQuery' => [
            [PositionApiInterface::QUERY_KEY_COORDS => 'POINT(-0.18 51.55)'],
            null,
        ];
        yield 'emptyQuery' => [
            [PositionApiInterface::QUERY_KEY_COORDS => 'POINT(-0.18 51.55)'],
            new DataQuery(),
        ];
        yield 'fullQuery' => [
            [
                PositionApiInterface::QUERY_KEY_COORDS => 'POINT(-0.18 51.55)',
                PositionApiInterface::QUERY_KEY_PARAMETER_NAME => 'airTemperature1p5m',
                PositionApiInterface::QUERY_KEY_PERCENTILES => '50,90',
                PositionApiInterface::QUERY_KEY_DATETIME => '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
            ],
            new DataQuery(
                ['airTemperature1p5m'],
                ['50', '90'],
                '2026-08-13T00:00:00Z/2026-08-14T00:00:00Z',
            ),
        ];
    }
}
