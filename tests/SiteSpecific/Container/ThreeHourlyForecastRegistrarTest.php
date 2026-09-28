<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\SiteSpecific\Api\ThreeHourlyForecastApi;
use ChristianBrown\MetOffice\SiteSpecific\Container\ThreeHourlyForecastRegistrar;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ThreeHourlyForecastRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
final class ThreeHourlyForecastRegistrarTest extends TestCase
{
    public function testRegisterWiresTheThreeHourlyForecastApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            SiteSpecificInterface::SERVICE_API_CLIENT,
            SiteSpecificInterface::SERVICE_JSON_API_REQUEST_SENDER,
            SiteSpecificInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new ThreeHourlyForecastRegistrar(new ApiHost()))->register($container);

        self::assertSame(ThreeHourlyForecastApi::class, $container->getDefinition(SiteSpecificInterface::SERVICE_THREE_HOURLY_FORECAST_API)->getClass());
    }
}
