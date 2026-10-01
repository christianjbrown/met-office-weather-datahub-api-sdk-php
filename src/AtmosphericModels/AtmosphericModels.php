<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApiInterface;

final class AtmosphericModels implements AtmosphericModelsInterface
{
    private OrdersApiInterface $ordersApi;
    private RunsApiInterface $runsApi;

    public function __construct(
        OrdersApiInterface $ordersApi,
        RunsApiInterface $runsApi
    ) {
        $this->ordersApi = $ordersApi;
        $this->runsApi = $runsApi;
    }

    public function getOrdersApi(): OrdersApiInterface
    {
        return $this->ordersApi;
    }

    public function getRunsApi(): RunsApiInterface
    {
        return $this->runsApi;
    }
}
