<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Model;

use ChristianBrown\MetOffice\SiteSpecific\Model\Forecast;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadataInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Forecast::class)]
final class ForecastTest extends TestCase
{
    public function test(): void
    {
        $forecast = new Forecast();
        self::assertNull($forecast->getElevation());
        self::assertNull($forecast->getLocationLicence());
        self::assertNull($forecast->getLocationName());
        self::assertNull($forecast->getModelRunDate());
        self::assertSame([], $forecast->getParameters());
        self::assertNull($forecast->getRequestPointDistance());
        self::assertSame([], $forecast->getTimeSteps());

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep2 = self::createStub(ForecastTimeStepInterface::class);
        $parameterMetadata = self::createStub(ParameterMetadataInterface::class);

        self::assertSame($forecast, $forecast->setElevation(12.5));
        self::assertSame($forecast, $forecast->setLocationLicence('test-licence'));
        self::assertSame($forecast, $forecast->setLocationName('test-location-name'));
        self::assertSame($forecast, $forecast->setModelRunDate(123));
        self::assertSame($forecast, $forecast->setParameters(['test-parameter' => $parameterMetadata]));
        self::assertSame($forecast, $forecast->setRequestPointDistance(456.5));
        self::assertSame($forecast, $forecast->setTimeSteps([$timeStep1]));
        self::assertSame($forecast, $forecast->addTimeStep($timeStep2));

        self::assertSame(12.5, $forecast->getElevation());
        self::assertSame('test-licence', $forecast->getLocationLicence());
        self::assertSame('test-location-name', $forecast->getLocationName());
        self::assertSame(123, $forecast->getModelRunDate());
        self::assertSame(['test-parameter' => $parameterMetadata], $forecast->getParameters());
        self::assertSame(456.5, $forecast->getRequestPointDistance());
        self::assertSame([$timeStep1, $timeStep2], $forecast->getTimeSteps());
    }
}
