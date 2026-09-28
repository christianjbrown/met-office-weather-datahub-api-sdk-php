<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\SiteSpecific\Api\HourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Container\HourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(HourlyForecastRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
final class HourlyForecastRegistrarTest extends TestCase
{
    public function testRegisterWiresTheHourlyForecastApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            SiteSpecificInterface::SERVICE_API_CLIENT,
            SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER,
            SiteSpecificInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new HourlyForecastRegistrar(new ApiHost()))->register($container);

        self::assertSame(HourlyForecastApi::class, $container->getDefinition(SiteSpecificInterface::SERVICE_HOURLY_FORECAST_API)->getClass());
    }
}
