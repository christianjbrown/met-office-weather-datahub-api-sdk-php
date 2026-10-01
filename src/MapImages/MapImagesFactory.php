<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;
use ChristianBrown\MetOffice\MapImages\Container\OrdersApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\RunsApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\TransformersRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Composition root for MapImages: wires the container of registrars and hands the
 * resulting API services to the facade.
 */
final class MapImagesFactory implements MapImagesFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): MapImagesInterface
    {
        $container = (new RegistrarContainerFactory(
            [
                new CoreRegistrar(MapImagesInterface::SERVICE_API_CLIENT, MapImagesInterface::SERVICE_JSON_API_REQUEST_SENDER, MapImagesInterface::SERVICE_API_KEY, $apiKey),
                new RawRequestSenderRegistrar(MapImagesInterface::SERVICE_API_CLIENT, MapImagesInterface::SERVICE_API_REQUEST_SENDER),
                new TransformersRegistrar(),
                new RunsApiRegistrar($apiHost),
                new OrdersApiRegistrar($apiHost),
            ]
        ))->build();
        /**
         * @var OrdersApiInterface $ordersApi
         */
        $ordersApi = $container->get(MapImagesInterface::SERVICE_ORDERS_API);

        /**
         * @var RunsApiInterface $runsApi
         */
        $runsApi = $container->get(MapImagesInterface::SERVICE_RUNS_API);

        return new MapImages($ordersApi, $runsApi);
    }
}
