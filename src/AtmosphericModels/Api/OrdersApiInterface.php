<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Api;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileDetailsInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderInterface;

interface OrdersApiInterface extends ApiInterface
{
    public function getOrderFile(string $orderId, string $fileId): OrderFileDetailsInterface;

    public function getOrderFileData(string $orderId, string $fileId): string;

    /**
     * @return array<int, OrderFileInterface>
     */
    public function getOrderFiles(string $orderId, ?string $detail = null, ?string $runFilter = null): array;

    /**
     * @return array<int, OrderInterface>
     */
    public function getOrders(): array;
}
