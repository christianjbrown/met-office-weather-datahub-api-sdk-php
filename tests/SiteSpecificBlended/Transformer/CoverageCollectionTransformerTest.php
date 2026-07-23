<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageCollection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoveragesTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParametersTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverageCollection::class)]
#[CoversClass(CoverageCollectionTransformer::class)]
final class CoverageCollectionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $parametersData = ['parameters-data'];
        $coveragesData = ['coverages-data'];

        $parameters = ['airTemperature' => self::createStub(ParameterInterface::class)];
        $coverages = [self::createStub(CoverageInterface::class)];

        $data = [
            CoverageCollectionTransformerInterface::KEY_DOMAIN_TYPE => 'PointSeries',
            CoverageCollectionTransformerInterface::KEY_PARAMETERS => $parametersData,
            CoverageCollectionTransformerInterface::KEY_COVERAGES => $coveragesData,
        ];

        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::once())
            ->method('transform')
            ->with($parametersData)
            ->willReturn($parameters);

        $coveragesTransformer = self::createMock(CoveragesTransformerInterface::class);
        $coveragesTransformer->expects(self::once())
            ->method('transform')
            ->with($coveragesData)
            ->willReturn($coverages);

        $collection = (new CoverageCollectionTransformer($parametersTransformer, $coveragesTransformer))->transform($data);

        self::assertSame('PointSeries', $collection->getDomainType());
        self::assertSame($parameters, $collection->getParameters());
        self::assertSame($coverages, $collection->getCoverages());
    }

    public function testTransformMinimal(): void
    {
        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::never())->method('transform');

        $coveragesTransformer = self::createMock(CoveragesTransformerInterface::class);
        $coveragesTransformer->expects(self::never())->method('transform');

        $collection = (new CoverageCollectionTransformer($parametersTransformer, $coveragesTransformer))->transform([]);

        self::assertNull($collection->getDomainType());
        self::assertSame([], $collection->getParameters());
        self::assertSame([], $collection->getCoverages());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::never())->method('transform');

        $coveragesTransformer = self::createMock(CoveragesTransformerInterface::class);
        $coveragesTransformer->expects(self::never())->method('transform');

        $collection = (new CoverageCollectionTransformer($parametersTransformer, $coveragesTransformer))->transform($data);

        self::assertNull($collection->getDomainType());
        self::assertSame([], $collection->getParameters());
        self::assertSame([], $collection->getCoverages());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                CoverageCollectionTransformerInterface::KEY_DOMAIN_TYPE => 42,
                CoverageCollectionTransformerInterface::KEY_PARAMETERS => 'not-an-array',
                CoverageCollectionTransformerInterface::KEY_COVERAGES => 'not-an-array',
            ],
        ];
    }
}
