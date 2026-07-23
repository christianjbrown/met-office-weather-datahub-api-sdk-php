<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Collection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ExtentInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Collection::class)]
final class CollectionTest extends TestCase
{
    public function test(): void
    {
        $crs = ['CRS84'];
        $extent = self::createStub(ExtentInterface::class);
        $links = [self::createStub(LinkInterface::class)];
        $outputFormats = ['CoverageJSON'];
        $parameterNames = ['feels_like_temperature'];

        $collection = new Collection('improver-percentiles-spot-global');
        self::assertSame([], $collection->getCrs());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame('improver-percentiles-spot-global', $collection->getId());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameterNames());
        self::assertNull($collection->getTitle());

        self::assertSame($collection, $collection->setCrs($crs));
        self::assertSame($collection, $collection->setDescription('A description'));
        self::assertSame($collection, $collection->setExtent($extent));
        self::assertSame($collection, $collection->setId('improver-probabilities-spot-uk'));
        self::assertSame($collection, $collection->setLinks($links));
        self::assertSame($collection, $collection->setOutputFormats($outputFormats));
        self::assertSame($collection, $collection->setParameterNames($parameterNames));
        self::assertSame($collection, $collection->setTitle('A title'));

        self::assertSame($crs, $collection->getCrs());
        self::assertSame('A description', $collection->getDescription());
        self::assertSame($extent, $collection->getExtent());
        self::assertSame('improver-probabilities-spot-uk', $collection->getId());
        self::assertSame($links, $collection->getLinks());
        self::assertSame($outputFormats, $collection->getOutputFormats());
        self::assertSame($parameterNames, $collection->getParameterNames());
        self::assertSame('A title', $collection->getTitle());
    }
}
