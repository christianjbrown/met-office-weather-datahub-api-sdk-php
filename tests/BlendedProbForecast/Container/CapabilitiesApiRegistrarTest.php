<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CapabilitiesApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LinksTransformerRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CapabilitiesApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(LinksTransformerRegistrar::class)]
final class CapabilitiesApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheCapabilitiesApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            BlendedProbForecastInterface::SERVICE_API_CLIENT,
            BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER,
            BlendedProbForecastInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new LinksTransformerRegistrar())->register($container);
        (new CapabilitiesApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(CapabilitiesApi::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_CAPABILITIES_API)->getClass());
    }
}
