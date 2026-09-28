<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ConformanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the landing page and conformance transformers plus the
 * `CapabilitiesApi` client. Depends on `LinksTransformerRegistrar` and
 * `CoreRegistrar` having already run.
 */
final class CapabilitiesApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_LANDING_PAGE_TRANSFORMER, LandingPageTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINKS_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_CONFORMANCE_TRANSFORMER, ConformanceTransformer::class);

        $container->register(BlendedProbForecastInterface::SERVICE_CAPABILITIES_API, CapabilitiesApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LANDING_PAGE_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_CONFORMANCE_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
