<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPageInterface;

interface LandingPageTransformerInterface
{
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LINKS = 'links';
    public const string KEY_TITLE = 'title';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LandingPageInterface;
}
