<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages\Container;

use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\MapImages\Container\TransformersRegistrar;
use ChristianBrown\MetOffice\MapImages\MapImagesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(TransformersRegistrar::class)]
final class TransformersRegistrarTest extends TestCase
{
    public function testRegisterWiresTheCoverageTransformerChain(): void
    {
        $container = new ContainerBuilder();

        (new TransformersRegistrar())->register($container);

        self::assertSame(RunsTransformer::class, $container->getDefinition(MapImagesInterface::SERVICE_RUNS_TRANSFORMER)->getClass());
        self::assertSame(OrdersTransformer::class, $container->getDefinition(MapImagesInterface::SERVICE_ORDERS_TRANSFORMER)->getClass());
        self::assertSame(OrderFileDetailsTransformer::class, $container->getDefinition(MapImagesInterface::SERVICE_ORDER_FILE_DETAILS_TRANSFORMER)->getClass());
    }
}
