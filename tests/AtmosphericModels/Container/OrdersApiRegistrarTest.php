<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Container;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModelsInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Container\OrdersApiRegistrar;
use ChristianBrown\MetOffice\AtmosphericModels\Container\TransformersRegistrar;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RawRequestSenderRegistrar;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(OrdersApiRegistrar::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(RawRequestSenderRegistrar::class)]
#[UsesClass(TransformersRegistrar::class)]
final class OrdersApiRegistrarTest extends TestCase
{
    public function testRegisterWiresTheOrdersApiService(): void
    {
        $container = new ContainerBuilder();

        (new CoreRegistrar(
            AtmosphericModelsInterface::SERVICE_API_CLIENT,
            AtmosphericModelsInterface::SERVICE_JSON_API_REQUEST_SENDER,
            AtmosphericModelsInterface::SERVICE_API_KEY,
            'test-api-key'
        ))->register($container);
        (new RawRequestSenderRegistrar(AtmosphericModelsInterface::SERVICE_API_CLIENT, AtmosphericModelsInterface::SERVICE_API_REQUEST_SENDER))
            ->register($container);
        (new TransformersRegistrar())->register($container);
        (new OrdersApiRegistrar(new ApiHost()))->register($container);

        self::assertSame(OrdersApi::class, $container->getDefinition(AtmosphericModelsInterface::SERVICE_ORDERS_API)->getClass());
    }
}
