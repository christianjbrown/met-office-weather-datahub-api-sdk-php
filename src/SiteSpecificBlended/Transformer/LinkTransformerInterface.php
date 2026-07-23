<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;

interface LinkTransformerInterface
{
    public const string KEY_HREF = 'href';
    public const string KEY_HREF_LANG = 'hreflang';
    public const string KEY_REL = 'rel';
    public const string KEY_TITLE = 'title';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LinkInterface;
}
