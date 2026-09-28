<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ParameterMetadataTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ThreeHourlyForecastTimeStepTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the three-hourly resolution's time step transformer, forecast
 * transformer, shared `ForecastApi`, and its thin `ThreeHourlyForecastApi`
 * wrapper.
 */
final class ThreeHourlyForecastRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER, ThreeHourlyForecastTimeStepTransformer::class);
        $container->register(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_PARAMETER_METADATA_TRANSFORMER, ParameterMetadataTransformer::class);
        $container->register(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_PARAMETER_METADATA_TRANSFORMER),
                ]
            );

        $container->register(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_API_KEY),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_API, ThreeHourlyForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST),
                    $this->apiHost,
                ]
            );
    }
}
