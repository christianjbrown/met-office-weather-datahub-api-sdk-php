<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the location transformer chain and the `LocationsApi` client.
 * Depends on `CoverageTransformerRegistrar` and `CoreRegistrar` having
 * already run.
 */
final class LocationsApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_LOCATIONS_API, LocationsApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LOCATIONS_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COVERAGE_COLLECTION_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
