<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the hourly resolution's time step transformer, forecast
 * transformer, shared `ForecastApi`, and its thin `HourlyForecastApi`
 * wrapper.
 */
final class HourlyForecastRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER, HourlyForecastTimeStepTransformer::class);
        $container->register(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER),
                ]
            );

        $container->register(SiteSpecificInterface::SERVICE_HOURLY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_TRANSFORMER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_API_KEY),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_API, HourlyForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_HOURLY_FORECAST),
                    $this->apiHost,
                ]
            );
    }
}
