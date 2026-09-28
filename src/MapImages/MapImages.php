<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;
use ChristianBrown\MetOffice\MapImages\Container\OrdersApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\RunsApiRegistrar;
use ChristianBrown\MetOffice\MapImages\Container\TransformersRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class MapImages implements MapImagesInterface
{
    private ContainerBuilder $container;

    public function __construct(string $apiKey, ?ApiHostInterface $apiHost = null)
    {
        $host = $apiHost ?? new ApiHost();
        $factory = new RegistrarContainerFactory(
            [
                new CoreRegistrar(self::SERVICE_API_CLIENT, self::SERVICE_JSON_API_REQUEST_SENDER, self::SERVICE_API_KEY, $apiKey),
                new RawRequestSenderRegistrar(self::SERVICE_API_CLIENT, self::SERVICE_API_REQUEST_SENDER),
                new TransformersRegistrar(),
                new RunsApiRegistrar($host),
                new OrdersApiRegistrar($host),
            ]
        );
        $this->container = $factory->build();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOrdersApi(): OrdersApiInterface
    {
        /**
         * @var OrdersApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ORDERS_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRunsApi(): RunsApiInterface
    {
        /**
         * @var RunsApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_RUNS_API);

        return $service;
    }
}
