<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CapabilitiesApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\CollectionsApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\Api\LocationsApi;
use ChristianBrown\MetOffice\SiteSpecificBlended\SiteSpecificBlended;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\AxisTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ConformanceTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ExtentTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LocationTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParameterTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangeTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiteSpecificBlended::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(CapabilitiesApi::class)]
#[UsesClass(CollectionsApi::class)]
#[UsesClass(LocationsApi::class)]
#[UsesClass(LinkTransformer::class)]
#[UsesClass(LinksTransformer::class)]
#[UsesClass(LandingPageTransformer::class)]
#[UsesClass(ConformanceTransformer::class)]
#[UsesClass(ExtentTransformer::class)]
#[UsesClass(CollectionTransformer::class)]
#[UsesClass(CollectionsTransformer::class)]
#[UsesClass(LocationTransformer::class)]
#[UsesClass(LocationsTransformer::class)]
#[UsesClass(ParameterTransformer::class)]
#[UsesClass(ParametersTransformer::class)]
#[UsesClass(RangeTransformer::class)]
#[UsesClass(RangesTransformer::class)]
#[UsesClass(AxisTransformer::class)]
#[UsesClass(AxesTransformer::class)]
#[UsesClass(DomainTransformer::class)]
#[UsesClass(CoverageTransformer::class)]
#[UsesClass(CoveragesTransformer::class)]
#[UsesClass(CoverageCollectionTransformer::class)]
final class SiteSpecificBlendedTest extends TestCase
{
    public function testGetCapabilitiesApi(): void
    {
        $siteSpecificBlended = new SiteSpecificBlended('key');

        self::assertInstanceOf(CapabilitiesApi::class, $siteSpecificBlended->getCapabilitiesApi());
    }

    public function testGetCollectionsApi(): void
    {
        $siteSpecificBlended = new SiteSpecificBlended('key');

        self::assertInstanceOf(CollectionsApi::class, $siteSpecificBlended->getCollectionsApi());
    }

    public function testGetLocationsApi(): void
    {
        $siteSpecificBlended = new SiteSpecificBlended('key');

        self::assertInstanceOf(LocationsApi::class, $siteSpecificBlended->getLocationsApi());
    }
}
