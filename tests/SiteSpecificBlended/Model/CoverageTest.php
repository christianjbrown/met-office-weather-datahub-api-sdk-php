<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Coverage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\DomainInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArrayInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Coverage::class)]
final class CoverageTest extends TestCase
{
    public function test(): void
    {
        $domain = self::createStub(DomainInterface::class);
        $otherDomain = self::createStub(DomainInterface::class);
        $ranges = ['airTemperature' => self::createStub(NdArrayInterface::class)];

        $coverage = new Coverage($domain);
        self::assertSame($domain, $coverage->getDomain());
        self::assertSame([], $coverage->getRanges());

        self::assertSame($coverage, $coverage->setDomain($otherDomain));
        self::assertSame($coverage, $coverage->setRanges($ranges));

        self::assertSame($otherDomain, $coverage->getDomain());
        self::assertSame($ranges, $coverage->getRanges());
    }
}
