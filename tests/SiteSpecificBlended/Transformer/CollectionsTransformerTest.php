<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CollectionInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionsTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionsTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CollectionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CollectionsTransformer::class)]
final class CollectionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['collection-1'], ['collection-2']];

        $collection1 = self::createStub(CollectionInterface::class);
        $collection2 = self::createStub(CollectionInterface::class);

        $collectionTransformer = self::createStub(CollectionTransformerInterface::class);
        $collectionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['collection-1'], $collection1],
                    [['collection-2'], $collection2],
                ]
            );

        $transformer = new CollectionsTransformer($collectionTransformer);

        self::assertSame([$collection1, $collection2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $collectionTransformer = self::createStub(CollectionTransformerInterface::class);

        $transformer = new CollectionsTransformer($collectionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $collectionTransformer = self::createStub(CollectionTransformerInterface::class);

        $transformer = new CollectionsTransformer($collectionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CollectionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CollectionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
