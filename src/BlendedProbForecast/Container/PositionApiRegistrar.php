<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `PositionApi` client. Depends on
 * `CoverageTransformerRegistrar` and `CoreRegistrar` having already run.
 */
final class PositionApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_POSITION_API, PositionApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COVERAGE_COLLECTION_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
