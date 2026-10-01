<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Container\NearestApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\Container\ObservationApiRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Composition root for ObservationLand: wires the container of registrars and hands the
 * resulting API services to the facade.
 */
final class ObservationLandFactory implements ObservationLandFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): ObservationLandInterface
    {
        $container = (new RegistrarContainerFactory(
            [
                new CoreRegistrar(ObservationLandInterface::SERVICE_API_CLIENT, ObservationLandInterface::SERVICE_JSON_API_REQUEST_SENDER, ObservationLandInterface::SERVICE_API_KEY, $apiKey),
                new NearestApiRegistrar($apiHost),
                new ObservationApiRegistrar($apiHost),
            ]
        ))->build();
        /**
         * @var NearestApiInterface $nearestApi
         */
        $nearestApi = $container->get(ObservationLandInterface::SERVICE_NEAREST_API);

        /**
         * @var ObservationApiInterface $observationApi
         */
        $observationApi = $container->get(ObservationLandInterface::SERVICE_OBSERVATION_API);

        return new ObservationLand($nearestApi, $observationApi);
    }
}
