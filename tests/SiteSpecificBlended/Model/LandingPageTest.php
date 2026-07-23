<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LandingPage::class)]
final class LandingPageTest extends TestCase
{
    public function test(): void
    {
        $links = [self::createStub(LinkInterface::class)];

        $landingPage = new LandingPage();
        self::assertNull($landingPage->getDescription());
        self::assertSame([], $landingPage->getLinks());
        self::assertNull($landingPage->getTitle());

        self::assertSame($landingPage, $landingPage->setDescription('A description'));
        self::assertSame($landingPage, $landingPage->setLinks($links));
        self::assertSame($landingPage, $landingPage->setTitle('A title'));

        self::assertSame('A description', $landingPage->getDescription());
        self::assertSame($links, $landingPage->getLinks());
        self::assertSame('A title', $landingPage->getTitle());
    }
}
