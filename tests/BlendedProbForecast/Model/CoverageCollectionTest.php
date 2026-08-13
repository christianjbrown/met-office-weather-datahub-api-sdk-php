<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollection;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverageCollection::class)]
final class CoverageCollectionTest extends TestCase
{
    public function test(): void
    {
        $coverages = [self::createStub(CoverageInterface::class)];
        $referencing = [self::createStub(ReferenceSystemInterface::class)];

        $coverageCollection = new CoverageCollection();
        self::assertSame([], $coverageCollection->getCoverages());
        self::assertNull($coverageCollection->getDomainType());
        self::assertSame([], $coverageCollection->getReferencing());

        self::assertSame($coverageCollection, $coverageCollection->setCoverages($coverages));
        self::assertSame($coverageCollection, $coverageCollection->setDomainType('PointSeries'));
        self::assertSame($coverageCollection, $coverageCollection->setReferencing($referencing));

        self::assertSame($coverages, $coverageCollection->getCoverages());
        self::assertSame('PointSeries', $coverageCollection->getDomainType());
        self::assertSame($referencing, $coverageCollection->getReferencing());
    }
}
