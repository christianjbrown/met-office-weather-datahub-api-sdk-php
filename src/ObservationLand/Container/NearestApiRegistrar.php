<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the nearest-location transformer chain and the `NearestApi`
 * client.
 */
final class NearestApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(ObservationLandInterface::SERVICE_NEAREST_LOCATION_TRANSFORMER, NearestLocationTransformer::class);
        $container->register(ObservationLandInterface::SERVICE_NEAREST_LOCATIONS_TRANSFORMER, NearestLocationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(ObservationLandInterface::SERVICE_NEAREST_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(ObservationLandInterface::SERVICE_NEAREST_API, NearestApi::class)
            ->setArguments(
                [
                    $container->getDefinition(ObservationLandInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(ObservationLandInterface::SERVICE_NEAREST_LOCATIONS_TRANSFORMER),
                    $container->getDefinition(ObservationLandInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
