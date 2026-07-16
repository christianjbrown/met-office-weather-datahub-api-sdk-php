<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages\Model;

use ChristianBrown\MetOffice\MapImages\Model\Order;
use ChristianBrown\MetOffice\MapImages\Model\RegionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Order::class)]
final class OrderTest extends TestCase
{
    public function test(): void
    {
        $region = self::createStub(RegionInterface::class);
        $regions = [$region];
        $requiredLatestRuns = ['00'];
        $timesteps = ['0', '3', '6'];

        $order = new Order('myorder');
        self::assertSame('myorder', $order->getOrderId());
        self::assertNull($order->getName());
        self::assertNull($order->getModelId());
        self::assertNull($order->getFormat());
        self::assertNull($order->getDescription());
        self::assertSame([], $order->getRegions());
        self::assertSame([], $order->getRequiredLatestRuns());
        self::assertSame([], $order->getTimesteps());

        self::assertSame($order, $order->setOrderId('otherorder'));
        self::assertSame($order, $order->setName('my_order'));
        self::assertSame($order, $order->setModelId('mo-global'));
        self::assertSame($order, $order->setFormat('GRIB2'));
        self::assertSame($order, $order->setDescription('Example order'));
        self::assertSame($order, $order->setRegions($regions));
        self::assertSame($order, $order->setRequiredLatestRuns($requiredLatestRuns));
        self::assertSame($order, $order->setTimesteps($timesteps));

        self::assertSame('otherorder', $order->getOrderId());
        self::assertSame('my_order', $order->getName());
        self::assertSame('mo-global', $order->getModelId());
        self::assertSame('GRIB2', $order->getFormat());
        self::assertSame('Example order', $order->getDescription());
        self::assertSame($regions, $order->getRegions());
        self::assertSame($requiredLatestRuns, $order->getRequiredLatestRuns());
        self::assertSame($timesteps, $order->getTimesteps());
    }
}
