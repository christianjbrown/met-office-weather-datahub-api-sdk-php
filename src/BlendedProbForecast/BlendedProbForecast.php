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
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class BlendedProbForecast implements BlendedProbForecastInterface
{
    private ContainerBuilder $container;

    public function __construct(string $apiKey, ?ApiHostInterface $apiHost = null)
    {
        $host = $apiHost ?? new ApiHost();
        $factory = new RegistrarContainerFactory(
            [
                new CoreRegistrar(self::SERVICE_API_CLIENT, self::SERVICE_JSON_API_REQUEST_SENDER, self::SERVICE_API_KEY, $apiKey),
                new LinksTransformerRegistrar(),
                new ExtentTransformerRegistrar(),
                new ParametersTransformerRegistrar(),
                new CoverageTransformerRegistrar(),
                new CapabilitiesApiRegistrar($host),
                new CollectionsApiRegistrar($host),
                new InstancesApiRegistrar($host),
                new LocationsApiRegistrar($host),
                new PositionApiRegistrar($host),
            ]
        );
        $this->container = $factory->build();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCapabilitiesApi(): CapabilitiesApiInterface
    {
        /**
         * @var CapabilitiesApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_CAPABILITIES_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCollectionsApi(): CollectionsApiInterface
    {
        /**
         * @var CollectionsApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_COLLECTIONS_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getInstancesApi(): InstancesApiInterface
    {
        /**
         * @var InstancesApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_INSTANCES_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLocationsApi(): LocationsApiInterface
    {
        /**
         * @var LocationsApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATIONS_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPositionApi(): PositionApiInterface
    {
        /**
         * @var PositionApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_POSITION_API);

        return $service;
    }
}
