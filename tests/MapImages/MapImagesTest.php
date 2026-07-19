<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages;

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
use ChristianBrown\MetOffice\MapImages\Api\OrdersApi;
use ChristianBrown\MetOffice\MapImages\Api\RunsApi;
use ChristianBrown\MetOffice\MapImages\MapImages;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MapImages::class)]
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
final class MapImagesTest extends TestCase
{
    public function testGetOrdersApi(): void
    {
        $mapImages = new MapImages('key');

        self::assertInstanceOf(OrdersApi::class, $mapImages->getOrdersApi());
    }

    public function testGetRunsApi(): void
    {
        $mapImages = new MapImages('key');

        self::assertInstanceOf(RunsApi::class, $mapImages->getRunsApi());
    }
}
