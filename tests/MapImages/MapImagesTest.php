<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages;

use ChristianBrown\MetOffice\MapImages\Api\OrdersApi;
use ChristianBrown\MetOffice\MapImages\Api\RunsApi;
use ChristianBrown\MetOffice\MapImages\MapImages;
use ChristianBrown\MetOffice\MapImages\Transformer\AxisExtentTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\OrderFilesTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\OrderFileTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\OrderTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\ParameterDetailsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\ParameterDetailTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RegionsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RegionTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RunDetailsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RunDetailTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\RunTransformer;
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
