<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\Instance;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LinkInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Instance::class)]
final class InstanceTest extends TestCase
{
    public function test(): void
    {
        $crs = ['EPSG:4326'];
        $dataQueries = ['locations', 'position'];
        $extent = self::createStub(ExtentInterface::class);
        $links = [self::createStub(LinkInterface::class)];
        $outputFormats = ['CoverageJSON', 'GeoJSON'];
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];

        $instance = new Instance('blended');
        self::assertSame([], $instance->getCrs());
        self::assertSame([], $instance->getDataQueries());
        self::assertNull($instance->getExtent());
        self::assertSame('blended', $instance->getId());
        self::assertSame([], $instance->getLinks());
        self::assertSame([], $instance->getOutputFormats());
        self::assertSame([], $instance->getParameters());

        self::assertSame($instance, $instance->setCrs($crs));
        self::assertSame($instance, $instance->setDataQueries($dataQueries));
        self::assertSame($instance, $instance->setExtent($extent));
        self::assertSame($instance, $instance->setId('other'));
        self::assertSame($instance, $instance->setLinks($links));
        self::assertSame($instance, $instance->setOutputFormats($outputFormats));
        self::assertSame($instance, $instance->setParameters($parameters));

        self::assertSame($crs, $instance->getCrs());
        self::assertSame($dataQueries, $instance->getDataQueries());
        self::assertSame($extent, $instance->getExtent());
        self::assertSame('other', $instance->getId());
        self::assertSame($links, $instance->getLinks());
        self::assertSame($outputFormats, $instance->getOutputFormats());
        self::assertSame($parameters, $instance->getParameters());
    }
}
