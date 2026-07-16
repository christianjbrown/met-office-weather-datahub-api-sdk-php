<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand;

use ChristianBrown\MetOffice\ObservationLand\Api\NearestApi;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApi;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\NearestLocationTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ObservationLand::class)]
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
