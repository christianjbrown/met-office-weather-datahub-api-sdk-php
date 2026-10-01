<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CapabilitiesApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CollectionsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CoverageTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ExtentTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\InstancesApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LinksTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LocationsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\PositionApiRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Composition root for BlendedProbForecast: wires the container of registrars and hands the
 * resulting API services to the facade.
 */
final class BlendedProbForecastFactory implements BlendedProbForecastFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): BlendedProbForecastInterface
    {
        $container = (new RegistrarContainerFactory(
            [
                new CoreRegistrar(BlendedProbForecastInterface::SERVICE_API_CLIENT, BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER, BlendedProbForecastInterface::SERVICE_API_KEY, $apiKey),
                new LinksTransformerRegistrar(),
                new ExtentTransformerRegistrar(),
                new ParametersTransformerRegistrar(),
                new CoverageTransformerRegistrar(),
                new CapabilitiesApiRegistrar($apiHost),
                new CollectionsApiRegistrar($apiHost),
                new InstancesApiRegistrar($apiHost),
                new LocationsApiRegistrar($apiHost),
                new PositionApiRegistrar($apiHost),
            ]
        ))->build();
        /**
         * @var CapabilitiesApiInterface $capabilitiesApi
         */
        $capabilitiesApi = $container->get(BlendedProbForecastInterface::SERVICE_CAPABILITIES_API);

        /**
         * @var CollectionsApiInterface $collectionsApi
         */
        $collectionsApi = $container->get(BlendedProbForecastInterface::SERVICE_COLLECTIONS_API);

        /**
         * @var InstancesApiInterface $instancesApi
         */
        $instancesApi = $container->get(BlendedProbForecastInterface::SERVICE_INSTANCES_API);

        /**
         * @var LocationsApiInterface $locationsApi
         */
        $locationsApi = $container->get(BlendedProbForecastInterface::SERVICE_LOCATIONS_API);

        /**
         * @var PositionApiInterface $positionApi
         */
        $positionApi = $container->get(BlendedProbForecastInterface::SERVICE_POSITION_API);

        return new BlendedProbForecast($capabilitiesApi, $collectionsApi, $instancesApi, $locationsApi, $positionApi);
    }
}
