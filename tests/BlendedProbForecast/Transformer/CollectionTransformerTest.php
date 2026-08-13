<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Collection;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LinkInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CollectionTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Collection::class)]
#[CoversClass(CollectionTransformer::class)]
final class CollectionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $linksData = [['link-1']];
        $extentData = ['extent-data'];
        $parametersData = ['airTemperature1p5m' => ['type' => 'Parameter']];
        $links = [self::createStub(LinkInterface::class)];
        $extent = self::createStub(ExtentInterface::class);
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];

        $data = [
            CollectionTransformerInterface::KEY_ID => 'global-spot-percentiles',
            CollectionTransformerInterface::KEY_CRS => ['EPSG:4326', 42],
            CollectionTransformerInterface::KEY_DATA_QUERIES => ['instances' => ['link' => []]],
            CollectionTransformerInterface::KEY_DESCRIPTION => 'A description',
            CollectionTransformerInterface::KEY_EXTENT => $extentData,
            CollectionTransformerInterface::KEY_LINKS => $linksData,
            CollectionTransformerInterface::KEY_OUTPUT_FORMATS => ['CoverageJSON', 42],
            CollectionTransformerInterface::KEY_PARAMETER_NAMES => $parametersData,
            CollectionTransformerInterface::KEY_TITLE => 'A title',
        ];

        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::once())
            ->method('transform')
            ->with($linksData)
            ->willReturn($links);

        $extentTransformer = self::createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::once())
            ->method('transform')
            ->with($extentData)
            ->willReturn($extent);

        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::once())
            ->method('transform')
            ->with($parametersData)
            ->willReturn($parameters);

        $collection = (new CollectionTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);

        self::assertSame('global-spot-percentiles', $collection->getId());
        self::assertSame(['EPSG:4326'], $collection->getCrs());
        self::assertSame(['instances'], $collection->getDataQueries());
        self::assertSame('A description', $collection->getDescription());
        self::assertSame($extent, $collection->getExtent());
        self::assertSame($links, $collection->getLinks());
        self::assertSame(['CoverageJSON'], $collection->getOutputFormats());
        self::assertSame($parameters, $collection->getParameters());
        self::assertSame('A title', $collection->getTitle());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            CollectionTransformerInterface::KEY_ID => 'global-spot-percentiles',
        ];

        $collection = $this->transformExpectingNoDelegation($data);

        self::assertSame([], $collection->getCrs());
        self::assertSame([], $collection->getDataQueries());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameters());
        self::assertNull($collection->getTitle());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $collection = $this->transformExpectingNoDelegation($data);

        self::assertSame([], $collection->getCrs());
        self::assertSame([], $collection->getDataQueries());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameters());
        self::assertNull($collection->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                CollectionTransformerInterface::KEY_ID => 'global-spot-percentiles',
                CollectionTransformerInterface::KEY_CRS => 'not-an-array',
                CollectionTransformerInterface::KEY_DATA_QUERIES => 'not-an-array',
                CollectionTransformerInterface::KEY_DESCRIPTION => 42,
                CollectionTransformerInterface::KEY_EXTENT => 'not-an-array',
                CollectionTransformerInterface::KEY_LINKS => 'not-an-array',
                CollectionTransformerInterface::KEY_OUTPUT_FORMATS => 'not-an-array',
                CollectionTransformerInterface::KEY_PARAMETER_NAMES => 'not-an-array',
                CollectionTransformerInterface::KEY_TITLE => 42,
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CollectionTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $linksTransformer = self::createStub(LinksTransformerInterface::class);
        $extentTransformer = self::createStub(ExtentTransformerInterface::class);
        $parametersTransformer = self::createStub(ParametersTransformerInterface::class);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CollectionTransformerInterface::UNEXPECTED_STRING_SPRINTF, CollectionTransformerInterface::KEY_ID));

        (new CollectionTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function transformExpectingNoDelegation(array $data): Collection
    {
        $linksTransformer = $this->createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $extentTransformer = $this->createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::never())->method('transform');

        $parametersTransformer = $this->createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::never())->method('transform');

        $collection = (new CollectionTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);
        self::assertInstanceOf(Collection::class, $collection);

        return $collection;
    }
}
