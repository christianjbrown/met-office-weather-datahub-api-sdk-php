<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApi;
use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetailsInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFilesTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrdersTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(OrdersApi::class)]
#[UsesClass(ApiKey::class)]
final class OrdersApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOrderFile(): void
    {
        $fileDetailsData = ['test-file-details'];
        $data = [OrdersApiInterface::KEY_FILE_DETAILS => $fileDetailsData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                sprintf(OrdersApiInterface::API_URL_ORDER_FILE_SPRINTF, 'myorder', 'isbl_temperature_100000_+00'),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    OrdersApiInterface::HEADER_KEY_ACCEPT => OrdersApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $orderFileDetails = self::createStub(OrderFileDetailsInterface::class);

        $orderFileDetailsTransformer = self::createMock(OrderFileDetailsTransformerInterface::class);
        $orderFileDetailsTransformer->method('transform')
            ->with($fileDetailsData)
            ->willReturn($orderFileDetails);

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(OrdersTransformerInterface::class),
            self::createStub(OrderFilesTransformerInterface::class),
            $orderFileDetailsTransformer,
            new ApiKey('test-api-key')
        );

        self::assertSame($orderFileDetails, $api->getOrderFile('myorder', 'isbl_temperature_100000_+00'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOrderFileData(): void
    {
        $grib = "GRIB\x00\x01binary-bytes";

        $rawRequestSender = self::createMock(ApiRequestSenderInterface::class);
        $rawRequestSender->method('get')
            ->with(
                sprintf(OrdersApiInterface::API_URL_ORDER_FILE_DATA_SPRINTF, 'myorder', rawurlencode('isbl_temperature_100000_+00')),
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    OrdersApiInterface::HEADER_KEY_ACCEPT => OrdersApiInterface::HEADER_VALUE_ACCEPT_GRIB,
                ]
            )
            ->willReturn($grib);

        $api = new OrdersApi(
            self::createStub(JsonApiRequestSenderInterface::class),
            $rawRequestSender,
            self::createStub(OrdersTransformerInterface::class),
            self::createStub(OrderFilesTransformerInterface::class),
            self::createStub(OrderFileDetailsTransformerInterface::class),
            new ApiKey('test-api-key')
        );

        self::assertSame($grib, $api->getOrderFileData('myorder', 'isbl_temperature_100000_+00'));
    }

    /**
     * @param array<string, string> $expectedQuery
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetOrderFilesCases')]
    public function testGetOrderFiles(?string $detail, ?string $runFilter, array $expectedQuery): void
    {
        $filesData = [['test-file']];
        $data = [
            OrdersApiInterface::KEY_ORDER_DETAILS => [
                OrdersApiInterface::KEY_FILES => $filesData,
            ],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                sprintf(OrdersApiInterface::API_URL_ORDER_LATEST_SPRINTF, 'myorder'),
                $expectedQuery,
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    OrdersApiInterface::HEADER_KEY_ACCEPT => OrdersApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $file = self::createStub(OrderFileInterface::class);
        $files = [$file];

        $orderFilesTransformer = self::createMock(OrderFilesTransformerInterface::class);
        $orderFilesTransformer->method('transform')
            ->with($filesData)
            ->willReturn($files);

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(OrdersTransformerInterface::class),
            $orderFilesTransformer,
            self::createStub(OrderFileDetailsTransformerInterface::class),
            new ApiKey('test-api-key')
        );

        self::assertSame($files, $api->getOrderFiles('myorder', $detail, $runFilter));
    }

    /**
     * @return iterable<string, array{null|string, null|string, array<string, string>}>
     */
    public static function provideGetOrderFilesCases(): iterable
    {
        yield 'noParams' => [null, null, []];
        yield 'detailOnly' => ['FULL', null, [OrdersApiInterface::QUERY_KEY_DETAIL => 'FULL']];
        yield 'runFilterOnly' => [null, 'CURRENT', [OrdersApiInterface::QUERY_KEY_RUNFILTER => 'CURRENT']];
        yield 'bothParams' => [
            'MINIMAL',
            '2021012506',
            [
                OrdersApiInterface::QUERY_KEY_DETAIL => 'MINIMAL',
                OrdersApiInterface::QUERY_KEY_RUNFILTER => '2021012506',
            ],
        ];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[], OrdersApiInterface::KEY_ORDER_DETAILS])]
    #[TestWith([[OrdersApiInterface::KEY_ORDER_DETAILS => 'not-an-array'], OrdersApiInterface::KEY_ORDER_DETAILS])]
    #[TestWith([[OrdersApiInterface::KEY_ORDER_DETAILS => ['filler' => 1]], OrdersApiInterface::KEY_FILES])]
    #[TestWith([[OrdersApiInterface::KEY_ORDER_DETAILS => [OrdersApiInterface::KEY_FILES => 'not-an-array']], OrdersApiInterface::KEY_FILES])]
    public function testGetOrderFilesThrowsOnUnexpectedResponse(array $data, string $key): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $orderFilesTransformer = self::createMock(OrderFilesTransformerInterface::class);
        $orderFilesTransformer->expects(self::never())->method('transform');

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(OrdersTransformerInterface::class),
            $orderFilesTransformer,
            self::createStub(OrderFileDetailsTransformerInterface::class),
            new ApiKey('test-api-key')
        );

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersApiInterface::UNEXPECTED_RESPONSE_SPRINTF, $key));

        $api->getOrderFiles('myorder');
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[OrdersApiInterface::KEY_FILE_DETAILS => 'not-an-array']])]
    public function testGetOrderFileThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $orderFileDetailsTransformer = self::createMock(OrderFileDetailsTransformerInterface::class);
        $orderFileDetailsTransformer->expects(self::never())->method('transform');

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            self::createStub(OrdersTransformerInterface::class),
            self::createStub(OrderFilesTransformerInterface::class),
            $orderFileDetailsTransformer,
            new ApiKey('test-api-key')
        );

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersApiInterface::UNEXPECTED_RESPONSE_SPRINTF, OrdersApiInterface::KEY_FILE_DETAILS));

        $api->getOrderFile('myorder', 'isbl_temperature_100000_+00');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOrders(): void
    {
        $ordersData = [['test-order']];
        $data = [OrdersApiInterface::KEY_ORDERS => $ordersData];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                OrdersApiInterface::API_URL_ORDERS,
                [],
                [
                    ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key',
                    OrdersApiInterface::HEADER_KEY_ACCEPT => OrdersApiInterface::HEADER_VALUE_ACCEPT_JSON,
                ]
            )
            ->willReturn($data);

        $order = self::createStub(OrderInterface::class);
        $orders = [$order];

        $ordersTransformer = self::createMock(OrdersTransformerInterface::class);
        $ordersTransformer->method('transform')
            ->with($ordersData)
            ->willReturn($orders);

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            $ordersTransformer,
            self::createStub(OrderFilesTransformerInterface::class),
            self::createStub(OrderFileDetailsTransformerInterface::class),
            new ApiKey('test-api-key')
        );

        self::assertSame($orders, $api->getOrders());
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[OrdersApiInterface::KEY_ORDERS => 'not-an-array']])]
    public function testGetOrdersThrowsOnUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn($data);

        $ordersTransformer = self::createMock(OrdersTransformerInterface::class);
        $ordersTransformer->expects(self::never())->method('transform');

        $api = new OrdersApi(
            $requestSender,
            self::createStub(ApiRequestSenderInterface::class),
            $ordersTransformer,
            self::createStub(OrderFilesTransformerInterface::class),
            self::createStub(OrderFileDetailsTransformerInterface::class),
            new ApiKey('test-api-key')
        );

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersApiInterface::UNEXPECTED_RESPONSE_SPRINTF, OrdersApiInterface::KEY_ORDERS));

        $api->getOrders();
    }
}
