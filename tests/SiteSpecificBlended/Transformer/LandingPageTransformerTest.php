<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LandingPageTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\LinksTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LandingPage::class)]
#[CoversClass(LandingPageTransformer::class)]
final class LandingPageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $linksData = [['link-1']];
        $links = [self::createStub(LinkInterface::class)];

        $data = [
            LandingPageTransformerInterface::KEY_DESCRIPTION => 'A description',
            LandingPageTransformerInterface::KEY_LINKS => $linksData,
            LandingPageTransformerInterface::KEY_TITLE => 'A title',
        ];

        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::once())
            ->method('transform')
            ->with($linksData)
            ->willReturn($links);

        $landingPage = (new LandingPageTransformer($linksTransformer))->transform($data);

        self::assertSame('A description', $landingPage->getDescription());
        self::assertSame($links, $landingPage->getLinks());
        self::assertSame('A title', $landingPage->getTitle());
    }

    public function testTransformMinimal(): void
    {
        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $landingPage = (new LandingPageTransformer($linksTransformer))->transform([]);

        self::assertNull($landingPage->getDescription());
        self::assertSame([], $landingPage->getLinks());
        self::assertNull($landingPage->getTitle());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $landingPage = (new LandingPageTransformer($linksTransformer))->transform($data);

        self::assertNull($landingPage->getDescription());
        self::assertSame([], $landingPage->getLinks());
        self::assertNull($landingPage->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                LandingPageTransformerInterface::KEY_DESCRIPTION => 42,
                LandingPageTransformerInterface::KEY_LINKS => 'not-an-array',
                LandingPageTransformerInterface::KEY_TITLE => 42,
            ],
        ];
    }
}
