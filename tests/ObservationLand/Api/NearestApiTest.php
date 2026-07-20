<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Model\NearestLocationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(NearestApi::class)]
#[UsesClass(Coordinates::class)]
#[UsesClass(ApiKey::class)]
final class NearestApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByCoordinates(): void
    {
        $data = [['test-location']];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                NearestApiInterface::API_URL_NEAREST,
                [
                    NearestApiInterface::QUERY_KEY_LAT => '51.55',
                    NearestApiInterface::QUERY_KEY_LON => '-0.18',
                ],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                ]
            )
            ->willReturn($data);

        $location = self::createStub(NearestLocationInterface::class);
        $locations = [$location];

        $transformer = self::createMock(NearestLocationsTransformerInterface::class);
        $transformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($locations);

        $api = new NearestApi($requestSender, $transformer, new ApiKey('test-api-key'));

        self::assertSame($locations, $api->getByCoordinates(new Coordinates(51.554, -0.181)));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByGeohash(): void
    {
        $data = [['test-location']];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                NearestApiInterface::API_URL_NEAREST,
                [
                    NearestApiInterface::QUERY_KEY_GEOHASH => 'gcpvj0',
                ],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                ]
            )
            ->willReturn($data);

        $location = self::createStub(NearestLocationInterface::class);
        $locations = [$location];

        $transformer = self::createMock(NearestLocationsTransformerInterface::class);
        $transformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($locations);

        $api = new NearestApi($requestSender, $transformer, new ApiKey('test-api-key'));

        self::assertSame($locations, $api->getByGeohash('gcpvj0'));
    }
}
