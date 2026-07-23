<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPageInterface;

use function is_array;
use function is_string;

final class LandingPageTransformer implements LandingPageTransformerInterface
{
    private LinksTransformerInterface $linksTransformer;

    public function __construct(LinksTransformerInterface $linksTransformer)
    {
        $this->linksTransformer = $linksTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LandingPageInterface
    {
        $landingPage = new LandingPage();

        self::applyDescription($landingPage, $data);
        $this->applyLinks($landingPage, $data);
        self::applyTitle($landingPage, $data);

        return $landingPage;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(LandingPage $landingPage, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $landingPage->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLinks(LandingPage $landingPage, array $data): void
    {
        if (!isset($data[self::KEY_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINKS])) {
            return;
        }
        $landingPage->setLinks($this->linksTransformer->transform($data[self::KEY_LINKS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(LandingPage $landingPage, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $landingPage->setTitle($data[self::KEY_TITLE]);
    }
}
