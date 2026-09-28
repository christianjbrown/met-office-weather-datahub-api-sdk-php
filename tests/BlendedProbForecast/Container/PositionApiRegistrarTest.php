<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CoverageTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\PositionApiRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(PositionApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(ParametersTransformerRegistrar::class)]
#[UsesClass(CoverageTransformerRegistrar::class)]
final class PositionApiRegistrarTest extends TestCase
{
    public function testRegisterWiresThePositionApiService(): void
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
        (new PositionApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(PositionApi::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_POSITION_API)->getClass());
    }
}
