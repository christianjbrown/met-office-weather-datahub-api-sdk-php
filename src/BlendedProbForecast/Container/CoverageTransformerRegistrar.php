<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangeTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformer;
use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the CoverageJSON transformer chain (ranges, axes, domain,
 * referencing, coverage, coverage collection) shared by `LocationsApi` and
 * `PositionApi`. Depends on `ParametersTransformerRegistrar` having already
 * run.
 */
final class CoverageTransformerRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BlendedProbForecastInterface::SERVICE_RANGE_TRANSFORMER, RangeTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_RANGES_TRANSFORMER, RangesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_RANGE_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_AXIS_TRANSFORMER, AxisTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_AXES_TRANSFORMER, AxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_AXIS_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_DOMAIN_TRANSFORMER, DomainTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_AXES_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_REFERENCE_SYSTEM_TRANSFORMER, ReferenceSystemTransformer::class);
        $container->register(BlendedProbForecastInterface::SERVICE_REFERENCING_TRANSFORMER, ReferencingTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_REFERENCE_SYSTEM_TRANSFORMER),
                ]
            );

        $container->register(BlendedProbForecastInterface::SERVICE_COVERAGE_TRANSFORMER, CoverageTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_DOMAIN_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_PARAMETERS_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_RANGES_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_COVERAGES_TRANSFORMER, CoveragesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COVERAGE_TRANSFORMER),
                ]
            );
        $container->register(BlendedProbForecastInterface::SERVICE_COVERAGE_COLLECTION_TRANSFORMER, CoverageCollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_COVERAGES_TRANSFORMER),
                    $container->getDefinition(BlendedProbForecastInterface::SERVICE_REFERENCING_TRANSFORMER),
                ]
            );
    }
}
