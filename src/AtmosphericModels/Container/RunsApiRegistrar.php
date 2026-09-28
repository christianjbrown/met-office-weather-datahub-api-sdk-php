<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Container;

use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
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
        $container->register(AtmosphericModelsInterface::SERVICE_RUNS_API, RunsApi::class)
            ->setArguments(
                [
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_RUNS_TRANSFORMER),
                    $container->getDefinition(AtmosphericModelsInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
