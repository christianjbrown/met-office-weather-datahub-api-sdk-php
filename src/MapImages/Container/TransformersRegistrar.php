<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
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
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the shared `Coverage\Transformer` chain (run/order/file schema)
 * that both `RunsApi` and `OrdersApi` depend on.
 */
final class TransformersRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(MapImagesInterface::SERVICE_AXIS_EXTENT_TRANSFORMER, AxisExtentTransformer::class);
        $container->register(MapImagesInterface::SERVICE_REGION_TRANSFORMER, RegionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_AXIS_EXTENT_TRANSFORMER),
                ]
            );
        $container->register(MapImagesInterface::SERVICE_REGIONS_TRANSFORMER, RegionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_REGION_TRANSFORMER),
                ]
            );

        $container->register(MapImagesInterface::SERVICE_RUN_DETAIL_TRANSFORMER, RunDetailTransformer::class);
        $container->register(MapImagesInterface::SERVICE_RUN_DETAILS_TRANSFORMER, RunDetailsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_RUN_DETAIL_TRANSFORMER),
                ]
            );
        $container->register(MapImagesInterface::SERVICE_RUN_TRANSFORMER, RunTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_RUN_DETAILS_TRANSFORMER),
                ]
            );
        $container->register(MapImagesInterface::SERVICE_RUNS_TRANSFORMER, RunsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_RUN_TRANSFORMER),
                ]
            );

        $container->register(MapImagesInterface::SERVICE_ORDER_TRANSFORMER, OrderTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_REGIONS_TRANSFORMER),
                ]
            );
        $container->register(MapImagesInterface::SERVICE_ORDERS_TRANSFORMER, OrdersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDER_TRANSFORMER),
                ]
            );

        $container->register(MapImagesInterface::SERVICE_ORDER_FILE_TRANSFORMER, OrderFileTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_REGION_TRANSFORMER),
                ]
            );
        $container->register(MapImagesInterface::SERVICE_ORDER_FILES_TRANSFORMER, OrderFilesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDER_FILE_TRANSFORMER),
                ]
            );

        $container->register(MapImagesInterface::SERVICE_PARAMETER_DETAIL_TRANSFORMER, ParameterDetailTransformer::class);
        $container->register(MapImagesInterface::SERVICE_PARAMETER_DETAILS_TRANSFORMER, ParameterDetailsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_PARAMETER_DETAIL_TRANSFORMER),
                ]
            );

        $container->register(MapImagesInterface::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER, OrderFileDetailsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(MapImagesInterface::SERVICE_ORDER_FILE_TRANSFORMER),
                    $container->getDefinition(MapImagesInterface::SERVICE_PARAMETER_DETAILS_TRANSFORMER),
                ]
            );
    }
}
