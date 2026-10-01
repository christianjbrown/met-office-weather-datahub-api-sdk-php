<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApiInterface;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AtmosphericModels::class)]
final class AtmosphericModelsTest extends TestCase
{
    public function testReturnsInjectedApis(): void
    {
        $ordersApi = self::createStub(OrdersApiInterface::class);
        $runsApi = self::createStub(RunsApiInterface::class);
        $facade = new AtmosphericModels($ordersApi, $runsApi);

        self::assertSame($ordersApi, $facade->getOrdersApi());
        self::assertSame($runsApi, $facade->getRunsApi());
    }
}
