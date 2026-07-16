<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApi;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ObservationApi::class)]
final class ObservationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByGeohash(): void
    {
        $data = [['test-observation']];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                sprintf(ObservationApiInterface::API_URL_OBSERVATION_SPRINTF, 'gcpvj0'),
                [],
                [
                    ObservationApiInterface::HEADER_KEY_API_KEY => 'test-api-key',
                ]
            )
            ->willReturn($data);

        $observation = self::createStub(ObservationInterface::class);
        $observations = [$observation];

        $transformer = self::createMock(ObservationsTransformerInterface::class);
        $transformer->method('transform')
            ->with($data)
            ->willReturn($observations);

        $api = new ObservationApi($requestSender, $transformer, 'test-api-key');

        self::assertSame($observations, $api->getByGeohash('gcpvj0'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByGeohashCaches(): void
    {
        $data = [['test-observation']];

        $observation = self::createStub(ObservationInterface::class);
        $observations = [$observation];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $transformer = self::createMock(ObservationsTransformerInterface::class);
        $transformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($observations);

        $api = new ObservationApi($requestSender, $transformer, 'test-api-key');

        // Second call for the same geohash is served from the cache without hitting the API.
        self::assertSame($observations, $api->getByGeohash('gcpvj0'));
        self::assertSame($observations, $api->getByGeohash('gcpvj0'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByGeohashSkipsCache(): void
    {
        $data = [['test-observation']];

        $observation = self::createStub(ObservationInterface::class);
        $observations = [$observation];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $transformer = self::createMock(ObservationsTransformerInterface::class);
        $transformer->method('transform')
            ->with($data)
            ->willReturn($observations);

        $api = new ObservationApi($requestSender, $transformer, 'test-api-key');

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($observations, $api->getByGeohash('gcpvj0'));
        self::assertSame($observations, $api->getByGeohash('gcpvj0', true));
    }
}
