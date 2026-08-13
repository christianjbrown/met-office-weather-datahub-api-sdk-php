<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Collection;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LinkInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Collection::class)]
final class CollectionTest extends TestCase
{
    public function test(): void
    {
        $crs = ['EPSG:4326'];
        $dataQueries = ['instances'];
        $extent = self::createStub(ExtentInterface::class);
        $links = [self::createStub(LinkInterface::class)];
        $outputFormats = ['CoverageJSON', 'GeoJSON'];
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];

        $collection = new Collection('global-spot-percentiles');
        self::assertSame([], $collection->getCrs());
        self::assertSame([], $collection->getDataQueries());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame('global-spot-percentiles', $collection->getId());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameters());
        self::assertNull($collection->getTitle());

        self::assertSame($collection, $collection->setCrs($crs));
        self::assertSame($collection, $collection->setDataQueries($dataQueries));
        self::assertSame($collection, $collection->setDescription('A description'));
        self::assertSame($collection, $collection->setExtent($extent));
        self::assertSame($collection, $collection->setId('uk-spot-probabilities'));
        self::assertSame($collection, $collection->setLinks($links));
        self::assertSame($collection, $collection->setOutputFormats($outputFormats));
        self::assertSame($collection, $collection->setParameters($parameters));
        self::assertSame($collection, $collection->setTitle('A title'));

        self::assertSame($crs, $collection->getCrs());
        self::assertSame($dataQueries, $collection->getDataQueries());
        self::assertSame('A description', $collection->getDescription());
        self::assertSame($extent, $collection->getExtent());
        self::assertSame('uk-spot-probabilities', $collection->getId());
        self::assertSame($links, $collection->getLinks());
        self::assertSame($outputFormats, $collection->getOutputFormats());
        self::assertSame($parameters, $collection->getParameters());
        self::assertSame('A title', $collection->getTitle());
    }
}
