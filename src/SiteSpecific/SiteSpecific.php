<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific;

use ChristianBrown\MetOffice\SiteSpecific\Api\DailyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;

final class SiteSpecific implements SiteSpecificInterface
{
    private DailyForecastApiInterface $dailyForecastApi;
    private HourlyForecastApiInterface $hourlyForecastApi;
    private ThreeHourlyForecastApiInterface $threeHourlyForecastApi;

    public function __construct(
        DailyForecastApiInterface $dailyForecastApi,
        HourlyForecastApiInterface $hourlyForecastApi,
        ThreeHourlyForecastApiInterface $threeHourlyForecastApi
    ) {
        $this->dailyForecastApi = $dailyForecastApi;
        $this->hourlyForecastApi = $hourlyForecastApi;
        $this->threeHourlyForecastApi = $threeHourlyForecastApi;
    }

    public function getDailyForecastApi(): DailyForecastApiInterface
    {
        return $this->dailyForecastApi;
    }

    public function getHourlyForecastApi(): HourlyForecastApiInterface
    {
        return $this->hourlyForecastApi;
    }

    public function getThreeHourlyForecastApi(): ThreeHourlyForecastApiInterface
    {
        return $this->threeHourlyForecastApi;
    }
}
