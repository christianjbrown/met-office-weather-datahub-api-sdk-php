<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinkTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LinksTransformer::class)]
final class LinksTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['link-1'], ['link-2']];

        $link1 = self::createStub(LinkInterface::class);
        $link2 = self::createStub(LinkInterface::class);

        $linkTransformer = self::createStub(LinkTransformerInterface::class);
        $linkTransformer->method('transform')
            ->willReturnMap(
                [
                    [['link-1'], $link1],
                    [['link-2'], $link2],
                ]
            );

        $transformer = new LinksTransformer($linkTransformer);

        self::assertSame([$link1, $link2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $linkTransformer = self::createStub(LinkTransformerInterface::class);

        $transformer = new LinksTransformer($linkTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $linkTransformer = self::createStub(LinkTransformerInterface::class);

        $transformer = new LinksTransformer($linkTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LinksTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LinksTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
