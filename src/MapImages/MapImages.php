<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\AxisExtentTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFilesTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunTransformer;
use ChristianBrown\MetOffice\MapImages\Api\OrdersApi;
use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApi;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MapImages implements MapImagesInterface
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

    private function init(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);
        $this->container->register(self::SERVICE_API_REQUEST_SENDER, ApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getApiRequestSender']);

        $this->container->register(self::SERVICE_AXIS_EXTENT_TRANSFORMER, AxisExtentTransformer::class);
        $this->container->register(self::SERVICE_REGION_TRANSFORMER, RegionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AXIS_EXTENT_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_REGIONS_TRANSFORMER, RegionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REGION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_RUN_DETAIL_TRANSFORMER, RunDetailTransformer::class);
        $this->container->register(self::SERVICE_RUN_DETAILS_TRANSFORMER, RunDetailsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RUN_DETAIL_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_RUN_TRANSFORMER, RunTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RUN_DETAILS_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_RUNS_TRANSFORMER, RunsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RUN_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_TRANSFORMER, OrderTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REGIONS_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_ORDERS_TRANSFORMER, OrdersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_FILE_TRANSFORMER, OrderFileTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_REGION_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_ORDER_FILES_TRANSFORMER, OrderFilesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_FILE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PARAMETER_DETAIL_TRANSFORMER, ParameterDetailTransformer::class);
        $this->container->register(self::SERVICE_PARAMETER_DETAILS_TRANSFORMER, ParameterDetailsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PARAMETER_DETAIL_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER, OrderFileDetailsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ORDER_FILE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PARAMETER_DETAILS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_RUNS_API, RunsApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_RUNS_TRANSFORMER),
                    $this->apiKey,
                ]
            );
        $this->container->register(self::SERVICE_ORDERS_API, OrdersApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ORDERS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_FILES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER),
                    $this->apiKey,
                ]
            );
    }
}
