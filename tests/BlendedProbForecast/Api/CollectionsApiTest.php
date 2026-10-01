<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CollectionInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionsTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CollectionsApi::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
final class CollectionsApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCollection(): void
    {
        $data = ['id' => 'improver-percentiles-spot-global'];

        $requestSender = self::createMock(JsonReadApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(CollectionsApiInterface::API_URL_COLLECTION_SPRINTF, 'improver-percentiles-spot-global'),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    CollectionsApiInterface::HEADER_KEY_ACCEPT => CollectionsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $collection = self::createStub(CollectionInterface::class);

        $collectionsTransformer = self::createMock(CollectionsTransformerInterface::class);
        $collectionsTransformer->expects(self::never())->method('transform');

        $collectionTransformer = self::createMock(CollectionTransformerInterface::class);
        $collectionTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($collection);

        $api = new CollectionsApi($requestSender, $collectionsTransformer, $collectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($collection, $api->getCollection('improver-percentiles-spot-global'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCollections(): void
    {
        $collectionsData = [['id' => 'improver-percentiles-spot-global']];
        $data = [CollectionsApiInterface::KEY_COLLECTIONS => $collectionsData];

        $requestSender = self::createMock(JsonReadApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                CollectionsApiInterface::API_URL_COLLECTIONS,
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    CollectionsApiInterface::HEADER_KEY_ACCEPT => CollectionsApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $collection = self::createStub(CollectionInterface::class);
        $collections = [$collection];

        $collectionsTransformer = self::createMock(CollectionsTransformerInterface::class);
        $collectionsTransformer->expects(self::once())
            ->method('transform')
            ->with($collectionsData)
            ->willReturn($collections);

        $collectionTransformer = self::createMock(CollectionTransformerInterface::class);
        $collectionTransformer->expects(self::never())->method('transform');

        $api = new CollectionsApi($requestSender, $collectionsTransformer, $collectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        self::assertSame($collections, $api->getCollections());
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[CollectionsApiInterface::KEY_COLLECTIONS => 'not-an-array']])]
    public function testGetCollectionsThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonReadApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $collectionsTransformer = self::createMock(CollectionsTransformerInterface::class);
        $collectionsTransformer->expects(self::never())->method('transform');

        $collectionTransformer = self::createStub(CollectionTransformerInterface::class);

        $api = new CollectionsApi($requestSender, $collectionsTransformer, $collectionTransformer, new ApiKey('test-api-key'), new ApiHost());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CollectionsApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CollectionsApiInterface::KEY_COLLECTIONS));

        $api->getCollections();
    }
}
