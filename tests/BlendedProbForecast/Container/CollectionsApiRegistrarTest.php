<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecastInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\CollectionsApiRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ExtentTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\LinksTransformerRegistrar;
use ChristianBrown\MetOffice\BlendedProbForecast\Container\ParametersTransformerRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CollectionsApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(LinksTransformerRegistrar::class)]
#[UsesClass(ExtentTransformerRegistrar::class)]
#[UsesClass(ParametersTransformerRegistrar::class)]
final class CollectionsApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheCollectionsApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            BlendedProbForecastInterface::SERVICE_API_CLIENT,
            BlendedProbForecastInterface::SERVICE_JSON_API_REQUEST_SENDER,
            BlendedProbForecastInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new LinksTransformerRegistrar())->register($container);
        (new ExtentTransformerRegistrar())->register($container);
        (new ParametersTransformerRegistrar())->register($container);
        (new CollectionsApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(CollectionsApi::class, $container->getDefinition(BlendedProbForecastInterface::SERVICE_COLLECTIONS_API)->getClass());
    }
}
