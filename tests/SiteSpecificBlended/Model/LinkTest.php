<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Link;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Link::class)]
final class LinkTest extends TestCase
{
    public function test(): void
    {
        $link = new Link('https://example.com');
        self::assertSame('https://example.com', $link->getHref());
        self::assertNull($link->getHrefLang());
        self::assertNull($link->getRel());
        self::assertNull($link->getTitle());
        self::assertNull($link->getType());

        self::assertSame($link, $link->setHref('https://other.com'));
        self::assertSame($link, $link->setHrefLang('en'));
        self::assertSame($link, $link->setRel('self'));
        self::assertSame($link, $link->setTitle('Self'));
        self::assertSame($link, $link->setType('application/json'));

        self::assertSame('https://other.com', $link->getHref());
        self::assertSame('en', $link->getHrefLang());
        self::assertSame('self', $link->getRel());
        self::assertSame('Self', $link->getTitle());
        self::assertSame('application/json', $link->getType());
    }
}
