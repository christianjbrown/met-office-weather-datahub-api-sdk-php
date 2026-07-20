<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\DailyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\HourlyForecastTimeStepTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ThreeHourlyForecastTimeStepTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SiteSpecific implements SiteSpecificInterface
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

    private function init(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $this->container->register(self::SERVICE_API_KEY, ApiKey::class)
            ->setArguments(
                [
                    $this->apiKey,
                ]
            );

        $this->container->register(self::SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER, HourlyForecastTimeStepTransformer::class);
        $this->container->register(self::SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_HOURLY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER, ThreeHourlyForecastTimeStepTransformer::class);
        $this->container->register(self::SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_THREE_HOURLY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_THREE_HOURLY_FORECAST_TIME_STEPS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER, DailyForecastTimeStepTransformer::class);
        $this->container->register(self::SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER, ForecastTimeStepsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DAILY_FORECAST_TIME_STEP_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DAILY_FORECAST_TRANSFORMER, ForecastTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DAILY_FORECAST_TIME_STEPS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_HOURLY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_HOURLY_FORECAST_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_HOURLY_FORECAST_API, HourlyForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_HOURLY_FORECAST),
                ]
            );

        $this->container->register(self::SERVICE_THREE_HOURLY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_THREE_HOURLY_FORECAST_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_THREE_HOURLY_FORECAST_API, ThreeHourlyForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_THREE_HOURLY_FORECAST),
                ]
            );

        $this->container->register(self::SERVICE_DAILY_FORECAST, ForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DAILY_FORECAST_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_API_KEY),
                ]
            );
        $this->container->register(self::SERVICE_DAILY_FORECAST_API, DailyForecastApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DAILY_FORECAST),
                ]
            );
    }
}
