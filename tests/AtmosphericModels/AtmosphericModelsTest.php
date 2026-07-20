<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\AtmosphericModels\Api\OrdersApi;
use ChristianBrown\MetOffice\AtmosphericModels\Api\RunsApi;
use ChristianBrown\MetOffice\AtmosphericModels\AtmosphericModels;
use ChristianBrown\MetOffice\Coverage\Transformer\AxisExtentTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFilesTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RegionTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AtmosphericModels::class)]
#[UsesClass(ApiKey::class)]
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
