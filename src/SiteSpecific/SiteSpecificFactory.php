<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Container\DailyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\HourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\ThreeHourlyForecastRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Composition root for SiteSpecific: wires the container of registrars and hands the
 * resulting API services to the facade.
 */
final class SiteSpecificFactory implements SiteSpecificFactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $apiKey, ApiHostInterface $apiHost): SiteSpecificInterface
    {
        $container = (new RegistrarContainerFactory(
            [
                new CoreRegistrar(SiteSpecificInterface::SERVICE_API_CLIENT, SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER, SiteSpecificInterface::SERVICE_API_KEY, $apiKey),
                new HourlyForecastRegistrar($apiHost),
                new ThreeHourlyForecastRegistrar($apiHost),
                new DailyForecastRegistrar($apiHost),
            ]
        ))->build();
        /**
         * @var DailyForecastApiInterface $dailyForecastApi
         */
        $dailyForecastApi = $container->get(SiteSpecificInterface::SERVICE_DAILY_FORECAST_API);

        /**
         * @var HourlyForecastApiInterface $hourlyForecastApi
         */
        $hourlyForecastApi = $container->get(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_API);

        /**
         * @var ThreeHourlyForecastApiInterface $threeHourlyForecastApi
         */
        $threeHourlyForecastApi = $container->get(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_API);

        return new SiteSpecific($dailyForecastApi, $hourlyForecastApi, $threeHourlyForecastApi);
    }
}
