<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages;

use ChristianBrown\MetOffice\MapImages\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\MapImages\Api\RunsApiInterface;
use ChristianBrown\MetOffice\MapImages\MapImages;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MapImages::class)]
final class MapImagesTest extends TestCase
{
    public function testReturnsInjectedApis(): void
    {
        $ordersApi = self::createStub(OrdersApiInterface::class);
        $runsApi = self::createStub(RunsApiInterface::class);
        $facade = new MapImages($ordersApi, $runsApi);

        self::assertSame($ordersApi, $facade->getOrdersApi());
        self::assertSame($runsApi, $facade->getRunsApi());
    }
}
