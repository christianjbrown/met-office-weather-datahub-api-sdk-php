<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileDetailsInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFileDetailsTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFilesTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrdersTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function is_array;
use function rawurlencode;
use function sprintf;

final class OrdersApi implements OrdersApiInterface
{
    private string $apiKey;
    private OrderFileDetailsTransformerInterface $orderFileDetailsTransformer;
    private OrderFilesTransformerInterface $orderFilesTransformer;
    private OrdersTransformerInterface $ordersTransformer;
    private ApiRequestSenderInterface $rawRequestSender;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiRequestSenderInterface $rawRequestSender, OrdersTransformerInterface $ordersTransformer, OrderFilesTransformerInterface $orderFilesTransformer, OrderFileDetailsTransformerInterface $orderFileDetailsTransformer, string $apiKey)
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
            self::HEADER_KEY_API_KEY => $this->apiKey,
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
            self::HEADER_KEY_API_KEY => $this->apiKey,
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_GRIB,
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
            self::HEADER_KEY_API_KEY => $this->apiKey,
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_ORDER_LATEST_SPRINTF, $orderId), $this->buildFilesQuery($detail, $runFilter), $headers);

        return $this->orderFilesTransformer->transform($this->extractFiles($data));
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
            self::HEADER_KEY_API_KEY => $this->apiKey,
            self::HEADER_KEY_ACCEPT => self::HEADER_VALUE_ACCEPT_JSON,
        ];
        $data = $this->requestSender->get(self::API_URL_ORDERS, [], $headers);

        return $this->ordersTransformer->transform($this->extractOrders($data));
    }

    /**
     * @return array<string, string>
     */
    private function buildFilesQuery(?string $detail, ?string $runFilter): array
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
    private function extractFiles(array $data): array
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
    private function extractOrders(array $data): array
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
