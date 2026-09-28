<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Container;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `OrdersApi` client. Depends on `TransformersRegistrar`,
 * `CoreRegistrar`, and `RawRequestSenderRegistrar` having already run.
 */
final class OrdersApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(AtmosphericModelsInterface::SERVICE_ORDERS_API, OrdersApi::class)
            ->setArguments(
                [
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_API_REQUEST_SENDER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_ORDERS_TRANSFORMER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_ORDER_FILES_TRANSFORMER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
