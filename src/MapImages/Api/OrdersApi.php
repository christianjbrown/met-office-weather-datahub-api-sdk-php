<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKeyInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetailsInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;
use ChristianBrown\MetOffice\Coverage\Model\OrderInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFilesTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrdersTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function rawurlencode;
use function sprintf;

final class OrdersApi implements OrdersApiInterface
{
    private ApiKeyInterface $apiKey;
    private OrderFileDetailsTransformerInterface $orderFileDetailsTransformer;
    private OrderFilesTransformerInterface $orderFilesTransformer;
    private OrdersTransformerInterface $ordersTransformer;
    private ApiRequestSenderInterface $rawRequestSender;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $rawRequestSender, OrdersTransformerInterface $ordersTransformer, OrderFilesTransformerInterface $orderFilesTransformer, OrderFileDetailsTransformerInterface $orderFileDetailsTransformer, ApiKeyInterface $apiKey)
    {
        $this->requestSender = $requestSender;
        $this->rawRequestSender = $rawRequestSender;
        $this->ordersTransformer = $ordersTransformer;
        $this->orderFilesTransformer = $orderFilesTransformer;
        $this->orderFileDetailsTransformer = $orderFileDetailsTransformer;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOrderFile(string $orderId, string $fileId): OrderFileDetailsInterface
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_ORDER_FILE_SPRINTF, $orderId, $fileId), [], $headers);

        if (!isset($data[self::KEY_FILE_DETAILS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FILE_DETAILS));
        }
        if (!is_array($data[self::KEY_FILE_DETAILS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FILE_DETAILS));
        }

        return $this->orderFileDetailsTransformer->transform($data[self::KEY_FILE_DETAILS]);
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function getOrderFileData(string $orderId, string $fileId): string
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_PNG,
        ];

        return $this->rawRequestSender->get(sprintf(self::API_URL_ORDER_FILE_DATA_SPRINTF, $orderId, rawurlencode($fileId)), [], $headers);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, OrderFileInterface>
     */
    public function getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_ORDER_LATEST_SPRINTF, $orderId), self::buildFilesQuery($detail, $runFilter), $headers);

        return $this->orderFilesTransformer->transform(self::extractFiles($data));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, OrderInterface>
     */
    public function getOrders(): array
    {
        $headers = [
            ...$this->apiKey->toHeaders(),
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(self::API_URL_ORDERS, [], $headers);

        return $this->ordersTransformer->transform(self::extractOrders($data));
    }

    /**
     * @return array<string, string>
     */
    private static function buildFilesQuery(?string $detail, ?string $runFilter): array
    {
        $query = [];
        if (null !== $detail) {
            $query[self::QUERY_KEY_DETAIL] = $detail;
        }
        if (null !== $runFilter) {
            $query[self::QUERY_KEY_RUNFILTER] = $runFilter;
        }

        return $query;
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractFiles(array $data): array
    {
        if (!isset($data[self::KEY_ORDER_DETAILS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ORDER_DETAILS));
        }
        if (!is_array($data[self::KEY_ORDER_DETAILS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ORDER_DETAILS));
        }
        $orderDetails = $data[self::KEY_ORDER_DETAILS];
        if (!isset($orderDetails[self::KEY_FILES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FILES));
        }
        if (!is_array($orderDetails[self::KEY_FILES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_FILES));
        }

        return $orderDetails[self::KEY_FILES];
    }

    /**
     * @param mixed[] $data
     *
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private static function extractOrders(array $data): array
    {
        if (!isset($data[self::KEY_ORDERS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ORDERS));
        }
        if (!is_array($data[self::KEY_ORDERS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ORDERS));
        }

        return $data[self::KEY_ORDERS];
    }
}
