<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\Api\OrdersApi;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
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
        $container->register(MapImagesInterface::SERVICE_ORDERS_API, OrdersApi::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(MapImagesInterface::SERVICE_API_REQUEST_SENDER),
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDERS_TRANSFORMER),
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDER_FILES_TRANSFORMER),
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER),
                    $container->getDefinition(MapImagesInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
