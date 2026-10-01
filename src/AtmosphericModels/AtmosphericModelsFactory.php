<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Container\OrdersApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\RunsApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\TransformersRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Composition root for AtmosphericModels: wires the container of registrars and hands the
 * resulting API services to the facade.
 */
final class AtmosphericModelsFactory implements AtmosphericModelsFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): AtmosphericModelsInterface
    {
        $container = (new RegistrarContainerFactory(
            [
                new CoreRegistrar(AtmosphericModelsInterface::SERVICE_API_CLIENT, AtmosphericModelsInterface::SERVICE_JSON_API_REQUEST_SENDER, AtmosphericModelsInterface::SERVICE_API_KEY, $apiKey),
                new RawRequestSenderRegistrar(AtmosphericModelsInterface::SERVICE_API_CLIENT, AtmosphericModelsInterface::SERVICE_API_REQUEST_SENDER),
                new TransformersRegistrar(),
                new RunsApiRegistrar($apiHost),
                new OrdersApiRegistrar($apiHost),
            ]
        ))->build();
        /**
         * @var OrdersApiInterface $ordersApi
         */
        $ordersApi = $container->get(AtmosphericModelsInterface::SERVICE_ORDERS_API);

        /**
         * @var RunsApiInterface $runsApi
         */
        $runsApi = $container->get(AtmosphericModelsInterface::SERVICE_RUNS_API);

        return new AtmosphericModels($ordersApi, $runsApi);
    }
}
