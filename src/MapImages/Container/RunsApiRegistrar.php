<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApi;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `RunsApi` client. Depends on `TransformersRegistrar` and
 * `CoreRegistrar` having already run.
 */
final class RunsApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(MapImagesInterface::SERVICE_RUNS_API, RunsApi::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(MapImagesInterface::SERVICE_RUNS_TRANSFORMER),
                    $container->getDefinition(MapImagesInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
