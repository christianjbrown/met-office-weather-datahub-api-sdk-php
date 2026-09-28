<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Container;

use ChristianBrown\MetOffice\Container\ServiceRegistrarInterface;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers the daily resolution's time step transformer, forecast
 * transformer, shared `ForecastApi`, and its thin `DailyForecastApi`
 * wrapper.
 */
final class DailyForecastRegistrar implements ServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER, DailyForecastTimeStepTransformer::class);
        $container->register(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER),
                ]
            );

        $container->register(SiteSpecificInterface::SERVICE_DAILY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_DAILY_FORECAST_TRANSFORMER),
                    $container->getDefinition(SiteSpecificInterface::SERVICE_API_KEY),
                ]
            );
        $container->register(SiteSpecificInterface::SERVICE_DAILY_FORECAST_API, DailyForecastApi::class)
            ->setArguments(
                [
                    $container->getDefinition(SiteSpecificInterface::SERVICE_DAILY_FORECAST),
                    $this->apiHost,
                ]
            );
    }
}
