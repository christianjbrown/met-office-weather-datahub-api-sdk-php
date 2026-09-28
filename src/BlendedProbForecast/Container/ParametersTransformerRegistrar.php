<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the `Parameter`/`Parameters` transformer pair, reused by the
 * collection, instance, and coverage transformers.
 */
final class ParametersTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_PARAMETER_TRANSFORMER, ParameterTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_PARAMETERS_TRANSFORMER, ParametersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_PARAMETER_TRANSFORMER),
                ]
            );
    }
}
