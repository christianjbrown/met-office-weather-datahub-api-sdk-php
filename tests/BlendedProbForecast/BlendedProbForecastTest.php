<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast;

use ChristianBrown\MetOffice\BlendedProbForecast\Api\CapabilitiesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\CollectionsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\InstancesApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\LocationsApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Api\PositionApiInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\BlendedProbForecast;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BlendedProbForecast::class)]
final class BlendedProbForecastTest extends TestCase
{
    public function testReturnsInjectedApis(): void
    {
        $capabilitiesApi = self::createStub(CapabilitiesApiInterface::class);
        $collectionsApi = self::createStub(CollectionsApiInterface::class);
        $instancesApi = self::createStub(InstancesApiInterface::class);
        $locationsApi = self::createStub(LocationsApiInterface::class);
        $positionApi = self::createStub(PositionApiInterface::class);
        $facade = new BlendedProbForecast($capabilitiesApi, $collectionsApi, $instancesApi, $locationsApi, $positionApi);

        self::assertSame($capabilitiesApi, $facade->getCapabilitiesApi());
        self::assertSame($collectionsApi, $facade->getCollectionsApi());
        self::assertSame($instancesApi, $facade->getInstancesApi());
        self::assertSame($locationsApi, $facade->getLocationsApi());
        self::assertSame($positionApi, $facade->getPositionApi());
    }
}
