<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\MetOffice\Coordinates;
use ChristianBrown\MetOffice\SiteSpecific\Api\ForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApiInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(HourlyForecastApi::class)]
#[UsesClass(Coordinates::class)]
final class HourlyForecastApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetForecastDelegatesWithTheEndpointUrl(): void
    {
        $forecast = self::createStub(ForecastInterface::class);

        $coordinates = new Coordinates(51.5, -0.1);

        $forecastApi = self::createMock(ForecastApiInterface::class);
        $forecastApi->expects(self::once())
            ->method('getForecast')
            ->with(HourlyForecastApiInterface::API_URL, $coordinates, true)
            ->willReturn($forecast);

        $api = new HourlyForecastApi($forecastApi);

        self::assertSame($forecast, $api->getForecast($coordinates, true));
    }
}
