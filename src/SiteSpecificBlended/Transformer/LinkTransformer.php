<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Link;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;

use function is_string;
use function sprintf;

final class LinkTransformer implements LinkTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LinkInterface
    {
        if (empty($data[self::KEY_HREF])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_HREF));
        }
        if (!is_string($data[self::KEY_HREF])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_HREF));
        }
        $link = new Link($data[self::KEY_HREF]);

        self::applyHrefLang($link, $data);
        self::applyRel($link, $data);
        self::applyTitle($link, $data);
        self::applyType($link, $data);

        return $link;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHrefLang(Link $link, array $data): void
    {
        if (empty($data[self::KEY_HREF_LANG])) {
            return;
        }
        if (!is_string($data[self::KEY_HREF_LANG])) {
            return;
        }
        $link->setHrefLang($data[self::KEY_HREF_LANG]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRel(Link $link, array $data): void
    {
        if (empty($data[self::KEY_REL])) {
            return;
        }
        if (!is_string($data[self::KEY_REL])) {
            return;
        }
        $link->setRel($data[self::KEY_REL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(Link $link, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $link->setTitle($data[self::KEY_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(Link $link, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $link->setType($data[self::KEY_TYPE]);
    }
}
