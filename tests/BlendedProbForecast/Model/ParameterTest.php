<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Parameter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parameter::class)]
final class ParameterTest extends TestCase
{
    public function test(): void
    {
        $parameter = new Parameter('airTemperature1p5m');
        self::assertNull($parameter->getDescription());
        self::assertNull($parameter->getFileSuffix());
        self::assertNull($parameter->getHeight());
        self::assertSame('airTemperature1p5m', $parameter->getId());
        self::assertNull($parameter->getObservedPropertyId());
        self::assertNull($parameter->getObservedPropertyLabel());
        self::assertNull($parameter->getUnit());

        self::assertSame($parameter, $parameter->setDescription('A description'));
        self::assertSame($parameter, $parameter->setFileSuffix('temperature_at_screen_level.nc'));
        self::assertSame($parameter, $parameter->setHeight('height 1.5m'));
        self::assertSame($parameter, $parameter->setId('airPressureAtSeaLevel'));
        self::assertSame($parameter, $parameter->setObservedPropertyId('an-observed-property-id'));
        self::assertSame($parameter, $parameter->setObservedPropertyLabel('air_temperature'));
        self::assertSame($parameter, $parameter->setUnit('K'));

        self::assertSame('A description', $parameter->getDescription());
        self::assertSame('temperature_at_screen_level.nc', $parameter->getFileSuffix());
        self::assertSame('height 1.5m', $parameter->getHeight());
        self::assertSame('airPressureAtSeaLevel', $parameter->getId());
        self::assertSame('an-observed-property-id', $parameter->getObservedPropertyId());
        self::assertSame('air_temperature', $parameter->getObservedPropertyLabel());
        self::assertSame('K', $parameter->getUnit());
    }
}
