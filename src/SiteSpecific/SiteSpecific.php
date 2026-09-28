<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific;

use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\Host\ApiHostInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Container\DailyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\HourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\Container\ThreeHourlyForecastRegistrar;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SiteSpecific implements SiteSpecificInterface
{
    private ContainerBuilder $container;

    public function __construct(string $apiKey, ?ApiHostInterface $apiHost = null)
    {
        $host = $apiHost ?? new ApiHost();
        $factory = new RegistrarContainerFactory(
            [
                new CoreRegistrar(self::SERVICE_API_CLIENT, self::SERVICE_JSON_API_REQUEST_SENDER, self::SERVICE_API_KEY, $apiKey),
                new HourlyForecastRegistrar($host),
                new ThreeHourlyForecastRegistrar($host),
                new DailyForecastRegistrar($host),
            ]
        );
        $this->container = $factory->build();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDailyForecastApi(): DailyForecastApiInterface
    {
        /**
         * @var DailyForecastApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DAILY_FORECAST_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getHourlyForecastApi(): HourlyForecastApiInterface
    {
        /**
         * @var HourlyForecastApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_HOURLY_FORECAST_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getThreeHourlyForecastApi(): ThreeHourlyForecastApiInterface
    {
        /**
         * @var ThreeHourlyForecastApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_THREE_HOURLY_FORECAST_API);

        return $service;
    }
}
