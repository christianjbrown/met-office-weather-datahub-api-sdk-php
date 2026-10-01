<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand;

use ChristianBrown\MetOffice\ObservationLand\Api\NearestApiInterface;
use ChristianBrown\MetOffice\ObservationLand\Api\ObservationApiInterface;
use ChristianBrown\MetOffice\ObservationLand\ObservationLand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ObservationLand::class)]
final class ObservationLandTest extends TestCase
{
    public function testReturnsInjectedApis(): void
    {
        $nearestApi = self::createStub(NearestApiInterface::class);
        $observationApi = self::createStub(ObservationApiInterface::class);
        $facade = new ObservationLand($nearestApi, $observationApi);

        self::assertSame($nearestApi, $facade->getNearestApi());
        self::assertSame($observationApi, $facade->getObservationApi());
    }
}
