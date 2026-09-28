<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CoverageTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LocationsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(LocationsApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(ParametersTransformerRegistrar::class)]
#[UsesClass(CoverageTransformerRegistrar::class)]
final class LocationsApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheLocationsApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            BlendedProbForecastInterface::SERVICE_API_CLIENT,
            BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER,
            BlendedProbForecastInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new ParametersTransformerRegistrar())->register($container);
        (new CoverageTransformerRegistrar())->register($container);
        (new LocationsApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(LocationsApi::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_LOCATIONS_API)->getClass());
    }
}
