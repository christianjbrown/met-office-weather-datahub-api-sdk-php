<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Collection;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ExtentInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ExtentTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformerInterface;
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
        $links = [self::createStub(LinkInterface::class)];
        $extent = self::createStub(ExtentInterface::class);

        $data = [
            CollectionTransformerInterface::KEY_ID => 'improver-percentiles-spot-global',
            CollectionTransformerInterface::KEY_CRS => ['CRS84', 42],
            CollectionTransformerInterface::KEY_DESCRIPTION => 'A description',
            CollectionTransformerInterface::KEY_EXTENT => $extentData,
            CollectionTransformerInterface::KEY_LINKS => $linksData,
            CollectionTransformerInterface::KEY_OUTPUT_FORMATS => ['CoverageJSON', 42],
            CollectionTransformerInterface::KEY_PARAMETER_NAMES => [
                'feels_like_temperature' => ['type' => 'Parameter'],
                'screen_temperature' => ['type' => 'Parameter'],
            ],
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

        $collection = (new CollectionTransformer($linksTransformer, $extentTransformer))->transform($data);

        self::assertSame('improver-percentiles-spot-global', $collection->getId());
        self::assertSame(['CRS84'], $collection->getCrs());
        self::assertSame('A description', $collection->getDescription());
        self::assertSame($extent, $collection->getExtent());
        self::assertSame($links, $collection->getLinks());
        self::assertSame(['CoverageJSON'], $collection->getOutputFormats());
        self::assertSame(['feels_like_temperature', 'screen_temperature'], $collection->getParameterNames());
        self::assertSame('A title', $collection->getTitle());
    }

    public function testTransformMinimal(): void
    {
        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $extentTransformer = self::createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::never())->method('transform');

        $data = [
            CollectionTransformerInterface::KEY_ID => 'improver-percentiles-spot-global',
        ];

        $collection = (new CollectionTransformer($linksTransformer, $extentTransformer))->transform($data);

        self::assertSame([], $collection->getCrs());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameterNames());
        self::assertNull($collection->getTitle());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $extentTransformer = self::createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::never())->method('transform');

        $collection = (new CollectionTransformer($linksTransformer, $extentTransformer))->transform($data);

        self::assertSame([], $collection->getCrs());
        self::assertNull($collection->getDescription());
        self::assertNull($collection->getExtent());
        self::assertSame([], $collection->getLinks());
        self::assertSame([], $collection->getOutputFormats());
        self::assertSame([], $collection->getParameterNames());
        self::assertNull($collection->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                CollectionTransformerInterface::KEY_ID => 'improver-percentiles-spot-global',
                CollectionTransformerInterface::KEY_CRS => 'not-an-array',
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

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CollectionTransformerInterface::UNEXPECTED_STRING_SPRINTF, CollectionTransformerInterface::KEY_ID));

        (new CollectionTransformer($linksTransformer, $extentTransformer))->transform($data);
    }
}
