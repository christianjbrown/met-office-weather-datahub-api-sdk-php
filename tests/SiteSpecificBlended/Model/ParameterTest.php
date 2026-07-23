<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Parameter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parameter::class)]
final class ParameterTest extends TestCase
{
    public function test(): void
    {
        $parameter = new Parameter('feels_like_temperature');
        self::assertNull($parameter->getDescription());
        self::assertSame('feels_like_temperature', $parameter->getId());
        self::assertNull($parameter->getObservedPropertyId());
        self::assertNull($parameter->getObservedPropertyLabel());
        self::assertNull($parameter->getUnit());

        self::assertSame($parameter, $parameter->setDescription('Feels like temperature'));
        self::assertSame($parameter, $parameter->setId('screen_temperature'));
        self::assertSame($parameter, $parameter->setObservedPropertyId('https://example.com/def/temperature'));
        self::assertSame($parameter, $parameter->setObservedPropertyLabel('Air Temperature'));
        self::assertSame($parameter, $parameter->setUnit('degC'));

        self::assertSame('Feels like temperature', $parameter->getDescription());
        self::assertSame('screen_temperature', $parameter->getId());
        self::assertSame('https://example.com/def/temperature', $parameter->getObservedPropertyId());
        self::assertSame('Air Temperature', $parameter->getObservedPropertyLabel());
        self::assertSame('degC', $parameter->getUnit());
    }
}
