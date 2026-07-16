<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels;

use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApi;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\AxisExtentTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFilesTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFileTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\ParameterDetailsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\ParameterDetailTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RegionsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RegionTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunDetailsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunDetailTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AtmosphericModels::class)]
#[UsesClass(RunsApi::class)]
#[UsesClass(OrdersApi::class)]
#[UsesClass(AxisExtentTransformer::class)]
#[UsesClass(RegionTransformer::class)]
#[UsesClass(RegionsTransformer::class)]
#[UsesClass(RunDetailTransformer::class)]
#[UsesClass(RunDetailsTransformer::class)]
#[UsesClass(RunTransformer::class)]
#[UsesClass(RunsTransformer::class)]
#[UsesClass(OrderTransformer::class)]
#[UsesClass(OrdersTransformer::class)]
#[UsesClass(OrderFileTransformer::class)]
#[UsesClass(OrderFilesTransformer::class)]
#[UsesClass(ParameterDetailTransformer::class)]
#[UsesClass(ParameterDetailsTransformer::class)]
#[UsesClass(OrderFileDetailsTransformer::class)]
final class AtmosphericModelsTest extends TestCase
{
    public function testGetOrdersApi(): void
    {
        $atmosphericModels = new AtmosphericModels('key');

        self::assertInstanceOf(OrdersApi::class, $atmosphericModels->getOrdersApi());
    }

    public function testGetRunsApi(): void
    {
        $atmosphericModels = new AtmosphericModels('key');

        self::assertInstanceOf(RunsApi::class, $atmosphericModels->getRunsApi());
    }
}
