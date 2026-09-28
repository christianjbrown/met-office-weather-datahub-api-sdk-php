<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `Extent` transformer chain, reused by the collection and
 * instance transformers.
 */
final class ExtentTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_EXTENT_CUSTOM_TRANSFORMER, ExtentCustomTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_EXTENT_CUSTOMS_TRANSFORMER, ExtentCustomsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_EXTENT_CUSTOM_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_EXTENT_TRANSFORMER, ExtentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_EXTENT_CUSTOMS_TRANSFORMER),
                ]
            );
    }
}
