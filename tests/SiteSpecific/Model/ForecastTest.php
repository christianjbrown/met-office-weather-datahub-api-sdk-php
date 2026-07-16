<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Model;

use ChristianBrown\MetOffice\SiteSpecific\Model\Forecast;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Forecast::class)]
final class ForecastTest extends TestCase
{
    public function test(): void
    {
        $forecast = new Forecast();
        self::assertNull($forecast->getLocationName());
        self::assertNull($forecast->getModelRunDate());
        self::assertSame([], $forecast->getTimeSteps());

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep2 = self::createStub(ForecastTimeStepInterface::class);

        self::assertSame($forecast, $forecast->setLocationName('test-location-name'));
        self::assertSame($forecast, $forecast->setModelRunDate(123));
        self::assertSame($forecast, $forecast->setTimeSteps([$timeStep1]));
        self::assertSame($forecast, $forecast->addTimeStep($timeStep2));

        self::assertSame('test-location-name', $forecast->getLocationName());
        self::assertSame(123, $forecast->getModelRunDate());
        self::assertSame([$timeStep1, $timeStep2], $forecast->getTimeSteps());
    }
}
