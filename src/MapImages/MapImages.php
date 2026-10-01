<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages;

use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;

final class MapImages implements MapImagesInterface
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
