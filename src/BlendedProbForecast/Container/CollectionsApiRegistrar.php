<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the collection transformer chain and the `CollectionsApi`
 * client. Depends on `LinksTransformerRegistrar`, `ExtentTransformerRegistrar`,
 * `ParametersTransformerRegistrar`, and `CoreRegistrar` having already run.
 */
final class CollectionsApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_COLLECTION_TRANSFORMER, CollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_LINKS_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_EXTENT_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_PARAMETERS_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_COLLECTIONS_TRANSFORMER, CollectionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COLLECTION_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_COLLECTIONS_API, CollectionsApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COLLECTIONS_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COLLECTION_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
