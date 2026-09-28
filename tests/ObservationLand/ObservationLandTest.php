<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\Container\CoreRegistrar;
use ChristianBrown\MetOffice\Container\RegistrarContainerFactory;
use ChristianBrown\MetOffice\Host\ApiHost;
use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApi;
use ChristianBrown\MetOffice\ObservationLand\Container\NearestApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\Container\ObservationApiRegistrar;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ObservationLand::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ApiKey::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(RegistrarContainerFactory::class)]
#[UsesClass(NearestApiRegistrar::class)]
#[UsesClass(ObservationApiRegistrar::class)]
#[UsesClass(NearestApi::class)]
#[UsesClass(ObservationApi::class)]
#[UsesClass(NearestLocationTransformer::class)]
#[UsesClass(NearestLocationsTransformer::class)]
#[UsesClass(ObservationTransformer::class)]
#[UsesClass(ObservationsTransformer::class)]
final class ObservationLandTest extends TestCase
{
    public function testGetNearestApi(): void
    {
        $observationLand = new ObservationLand('key');

        self::assertInstanceOf(NearestApi::class, $observationLand->getNearestApi());
    }

    public function testGetObservationApi(): void
    {
        $observationLand = new ObservationLand('key');

        self::assertInstanceOf(ObservationApi::class, $observationLand->getObservationApi());
    }
}
