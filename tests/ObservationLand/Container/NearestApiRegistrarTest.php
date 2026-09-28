<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\Container\NearestApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\ObservationLandInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(NearestApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
final class NearestApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheNearestApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            ObservationLandInterface::SERVICE_API_CLIENT,
            ObservationLandInterface::SERVICE_JSON_API_REQUEST_SENDER,
            ObservationLandInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new NearestApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(NearestApi::class, $container->getDefinition(ObservationLandInterface::SERVICE_NEAREST_API)->getClass());
    }
}
