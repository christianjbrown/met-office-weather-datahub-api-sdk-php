<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Link;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinkTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Link::class)]
#[CoversClass(LinkTransformer::class)]
final class LinkTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LinkTransformerInterface::KEY_HREF => 'https://example.com',
            LinkTransformerInterface::KEY_HREF_LANG => 'en',
            LinkTransformerInterface::KEY_REL => 'self',
            LinkTransformerInterface::KEY_TITLE => 'Self',
            LinkTransformerInterface::KEY_TYPE => 'application/json',
        ];

        $link = (new LinkTransformer())->transform($data);

        self::assertSame('https://example.com', $link->getHref());
        self::assertSame('en', $link->getHrefLang());
        self::assertSame('self', $link->getRel());
        self::assertSame('Self', $link->getTitle());
        self::assertSame('application/json', $link->getType());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            LinkTransformerInterface::KEY_HREF => 'https://example.com',
        ];

        $link = (new LinkTransformer())->transform($data);

        self::assertSame('https://example.com', $link->getHref());
        self::assertNull($link->getHrefLang());
        self::assertNull($link->getRel());
        self::assertNull($link->getTitle());
        self::assertNull($link->getType());
    }

    public function testTransformSkipsWrongTypes(): void
    {
        $data = [
            LinkTransformerInterface::KEY_HREF => 'https://example.com',
            LinkTransformerInterface::KEY_HREF_LANG => 42,
            LinkTransformerInterface::KEY_REL => 42,
            LinkTransformerInterface::KEY_TITLE => 42,
            LinkTransformerInterface::KEY_TYPE => 42,
        ];

        $link = (new LinkTransformer())->transform($data);

        self::assertNull($link->getHrefLang());
        self::assertNull($link->getRel());
        self::assertNull($link->getTitle());
        self::assertNull($link->getType());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LinkTransformerInterface::KEY_HREF => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LinkTransformerInterface::UNEXPECTED_STRING_SPRINTF, LinkTransformerInterface::KEY_HREF));

        (new LinkTransformer())->transform($data);
    }
}
