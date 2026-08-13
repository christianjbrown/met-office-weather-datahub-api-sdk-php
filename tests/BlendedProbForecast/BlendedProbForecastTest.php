<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApi;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApi;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecast;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ConformanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentCustomTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangeTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BlendedProbForecast::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(CapabilitiesApi::class)]
#[UsesClass(CollectionsApi::class)]
#[UsesClass(InstancesApi::class)]
#[UsesClass(LocationsApi::class)]
#[UsesClass(PositionApi::class)]
#[UsesClass(LinkTransformer::class)]
#[UsesClass(LinksTransformer::class)]
#[UsesClass(LandingPageTransformer::class)]
#[UsesClass(ConformanceTransformer::class)]
#[UsesClass(ExtentCustomTransformer::class)]
#[UsesClass(ExtentCustomsTransformer::class)]
#[UsesClass(ExtentTransformer::class)]
#[UsesClass(CollectionTransformer::class)]
#[UsesClass(CollectionsTransformer::class)]
#[UsesClass(InstanceTransformer::class)]
#[UsesClass(InstancesTransformer::class)]
#[UsesClass(LocationTransformer::class)]
#[UsesClass(LocationsTransformer::class)]
#[UsesClass(ParameterTransformer::class)]
#[UsesClass(ParametersTransformer::class)]
#[UsesClass(RangeTransformer::class)]
#[UsesClass(RangesTransformer::class)]
#[UsesClass(AxisTransformer::class)]
#[UsesClass(AxesTransformer::class)]
#[UsesClass(DomainTransformer::class)]
#[UsesClass(ReferenceSystemTransformer::class)]
#[UsesClass(ReferencingTransformer::class)]
#[UsesClass(CoverageTransformer::class)]
#[UsesClass(CoveragesTransformer::class)]
#[UsesClass(CoverageCollectionTransformer::class)]
final class BlendedProbForecastTest extends TestCase
{
    public function testGetCapabilitiesApi(): void
    {
        $blendedProbForecast = new BlendedProbForecast('key');

        self::assertInstanceOf(CapabilitiesApi::class, $blendedProbForecast->getCapabilitiesApi());
    }

    public function testGetCollectionsApi(): void
    {
        $blendedProbForecast = new BlendedProbForecast('key');

        self::assertInstanceOf(CollectionsApi::class, $blendedProbForecast->getCollectionsApi());
    }

    public function testGetInstancesApi(): void
    {
        $blendedProbForecast = new BlendedProbForecast('key');

        self::assertInstanceOf(InstancesApi::class, $blendedProbForecast->getInstancesApi());
    }

    public function testGetLocationsApi(): void
    {
        $blendedProbForecast = new BlendedProbForecast('key');

        self::assertInstanceOf(LocationsApi::class, $blendedProbForecast->getLocationsApi());
    }

    public function testGetPositionApi(): void
    {
        $blendedProbForecast = new BlendedProbForecast('key');

        self::assertInstanceOf(PositionApi::class, $blendedProbForecast->getPositionApi());
    }
}
