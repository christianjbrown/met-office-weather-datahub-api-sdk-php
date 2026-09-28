<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the instance transformer chain and the `InstancesApi` client.
 * Depends on `LinksTransformerRegistrar`, `ExtentTransformerRegistrar`,
 * `ParametersTransformerRegistrar`, and `CoreRegistrar` having already run.
 */
final class InstancesApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_INSTANCE_TRANSFORMER, InstanceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINKS_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_EXTENT_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_PARAMETERS_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_INSTANCES_TRANSFORMER, InstancesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_INSTANCE_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_INSTANCES_API, InstancesApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_INSTANCES_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_INSTANCE_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
