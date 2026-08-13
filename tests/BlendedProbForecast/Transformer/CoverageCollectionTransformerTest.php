<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageCollection;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\CoverageInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageCollectionTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoveragesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverageCollection::class)]
#[CoversClass(CoverageCollectionTransformer::class)]
final class CoverageCollectionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $coveragesData = ['coverages-data'];
        $referencingData = ['referencing-data'];

        $coverages = [self::createStub(CoverageInterface::class)];
        $referencing = [self::createStub(ReferenceSystemInterface::class)];

        $data = [
            CoverageCollectionTransformerInterface::KEY_COVERAGES => $coveragesData,
            CoverageCollectionTransformerInterface::KEY_DOMAIN_TYPE => 'PointSeries',
            CoverageCollectionTransformerInterface::KEY_REFERENCING => $referencingData,
        ];

        $coveragesTransformer = self::createMock(CoveragesTransformerInterface::class);
        $coveragesTransformer->expects(self::once())
            ->method('transform')
            ->with($coveragesData)
            ->willReturn($coverages);

        $referencingTransformer = self::createMock(ReferencingTransformerInterface::class);
        $referencingTransformer->expects(self::once())
            ->method('transform')
            ->with($referencingData)
            ->willReturn($referencing);

        $collection = (new CoverageCollectionTransformer($coveragesTransformer, $referencingTransformer))->transform($data);

        self::assertSame($coverages, $collection->getCoverages());
        self::assertSame('PointSeries', $collection->getDomainType());
        self::assertSame($referencing, $collection->getReferencing());
    }

    public function testTransformMinimal(): void
    {
        $collection = $this->transformExpectingNoDelegation([]);

        self::assertSame([], $collection->getCoverages());
        self::assertNull($collection->getDomainType());
        self::assertSame([], $collection->getReferencing());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $collection = $this->transformExpectingNoDelegation($data);

        self::assertSame([], $collection->getCoverages());
        self::assertNull($collection->getDomainType());
        self::assertSame([], $collection->getReferencing());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                CoverageCollectionTransformerInterface::KEY_COVERAGES => 'not-an-array',
                CoverageCollectionTransformerInterface::KEY_DOMAIN_TYPE => 42,
                CoverageCollectionTransformerInterface::KEY_REFERENCING => 'not-an-array',
            ],
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function transformExpectingNoDelegation(array $data): CoverageCollection
    {
        $coveragesTransformer = $this->createMock(CoveragesTransformerInterface::class);
        $coveragesTransformer->expects(self::never())->method('transform');

        $referencingTransformer = $this->createMock(ReferencingTransformerInterface::class);
        $referencingTransformer->expects(self::never())->method('transform');

        $collection = (new CoverageCollectionTransformer($coveragesTransformer, $referencingTransformer))->transform($data);
        self::assertInstanceOf(CoverageCollection::class, $collection);

        return $collection;
    }
}
