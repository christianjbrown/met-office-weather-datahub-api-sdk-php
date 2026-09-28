<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApi;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the observation transformer chain and the `ObservationApi`
 * client.
 */
final class ObservationApiRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(ObservationLandInterface::SERVICE_OBSERVATION_TRANSFORMER, ObservationTransformer::class);
        $container->register(ObservationLandInterface::SERVICE_OBSERVATIONS_TRANSFORMER, ObservationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(ObservationLandInterface::SERVICE_OBSERVATION_TRANSFORMER),
                ]
            );

        $container->register(ObservationLandInterface::SERVICE_OBSERVATION_API, ObservationApi::class)
            ->setArguments(
                [
                    $container->getDefinition(ObservationLandInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(ObservationLandInterface::SERVICE_OBSERVATIONS_TRANSFORMER),
                    $container->getDefinition(ObservationLandInterface::SERVICE_API_KEY),
                    $this->apiHost,
                ]
            );
    }
}
