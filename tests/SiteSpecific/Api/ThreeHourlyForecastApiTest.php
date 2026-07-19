<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ThreeHourlyForecastApi::class)]
final class ThreeHourlyForecastApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastDelegatesWithTheEndpointUrl(): void
    {
        $forecast = self::createStub(ForecastInterface::class);

        $forecastApi = self::createMock(ForecastApiInterface::class);
        $forecastApi->expects(self::once())
            ->method('getForecast')
            ->with(ThreeHourlyForecastApiInterface::API_URL, 51.5, -0.1, true)
            ->willReturn($forecast);

        $api = new ThreeHourlyForecastApi($forecastApi);

        self::assertSame($forecast, $api->getForecast(51.5, -0.1, true));
    }
}
