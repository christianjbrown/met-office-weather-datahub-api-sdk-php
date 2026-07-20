<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApi;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ObservationLand implements ObservationLandInterface
{
    private string $apiKey;
    private ContainerBuilder $container;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->container = new ContainerBuilder();
        $this->init();
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

    private function init(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $this->container->register(self::SERVICE_API_KEY, ApiKey::class)
            ->setArguments(
                [
                    $this->apiKey,
                ]
            );

        $this->container->register(self::SERVICE_NEAREST_LOCATION_TRANSFORMER, NearestLocationTransformer::class);
        $this->container->register(self::SERVICE_NEAREST_LOCATIONS_TRANSFORMER, NearestLocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_NEAREST_LOCATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_OBSERVATION_TRANSFORMER, ObservationTransformer::class);
        $this->container->register(self::SERVICE_OBSERVATIONS_TRANSFORMER, ObservationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_OBSERVATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_NEAREST_API, NearestApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_NEAREST_LOCATIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_OBSERVATION_API, ObservationApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_OBSERVATIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
    }
}
