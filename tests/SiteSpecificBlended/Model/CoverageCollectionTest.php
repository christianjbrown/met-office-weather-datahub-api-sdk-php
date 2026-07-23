<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverageCollection::class)]
final class CoverageCollectionTest extends TestCase
{
    public function test(): void
    {
        $coverages = [self::createStub(CoverageInterface::class)];
        $parameters = ['airTemperature' => self::createStub(ParameterInterface::class)];

        $coverageCollection = new CoverageCollection();
        self::assertSame([], $coverageCollection->getCoverages());
        self::assertNull($coverageCollection->getDomainType());
        self::assertSame([], $coverageCollection->getParameters());

        self::assertSame($coverageCollection, $coverageCollection->setCoverages($coverages));
        self::assertSame($coverageCollection, $coverageCollection->setDomainType('PointSeries'));
        self::assertSame($coverageCollection, $coverageCollection->setParameters($parameters));

        self::assertSame($coverages, $coverageCollection->getCoverages());
        self::assertSame('PointSeries', $coverageCollection->getDomainType());
        self::assertSame($parameters, $coverageCollection->getParameters());
    }
}
