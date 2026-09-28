<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Container\NearestApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\Container\ObservationApiRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ObservationLand implements ObservationLandInterface
{
    private ContainerBuilder $container;

    public function __construct(string $apiKey, ?ApiHostInterface $apiHost = null)
    {
        $host = $apiHost ?? new ApiHost();
        $factory = new RegistrarContainerFactory(
            [
                new CoreRegistrar(self::SERVICE_API_CLIENT, self::SERVICE_JSON_API_REQUEST_SENDER, self::SERVICE_API_KEY, $apiKey),
                new NearestApiRegistrar($host),
                new ObservationApiRegistrar($host),
            ]
        );
        $this->container = $factory->build();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getNearestApi(): NearestApiInterface
    {
        /**
         * @var NearestApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_NEAREST_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getObservationApi(): ObservationApiInterface
    {
        /**
         * @var ObservationApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_OBSERVATION_API);

        return $service;
    }
}
