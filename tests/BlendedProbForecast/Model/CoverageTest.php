<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Coverage;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\DomainInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\NdArrayInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Coverage::class)]
final class CoverageTest extends TestCase
{
    public function test(): void
    {
        $domain = self::createStub(DomainInterface::class);
        $otherDomain = self::createStub(DomainInterface::class);
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];
        $ranges = ['airTemperature1p5m' => self::createStub(NdArrayInterface::class)];

        $coverage = new Coverage($domain);
        self::assertSame($domain, $coverage->getDomain());
        self::assertNull($coverage->getId());
        self::assertSame([], $coverage->getParameters());
        self::assertSame([], $coverage->getRanges());

        self::assertSame($coverage, $coverage->setDomain($otherDomain));
        self::assertSame($coverage, $coverage->setId('airTemperature1p5m'));
        self::assertSame($coverage, $coverage->setParameters($parameters));
        self::assertSame($coverage, $coverage->setRanges($ranges));

        self::assertSame($otherDomain, $coverage->getDomain());
        self::assertSame('airTemperature1p5m', $coverage->getId());
        self::assertSame($parameters, $coverage->getParameters());
        self::assertSame($ranges, $coverage->getRanges());
    }
}
