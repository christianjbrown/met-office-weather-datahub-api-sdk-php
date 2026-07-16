<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\SiteSpecific\SiteSpecific;
use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;

final class MetOffice implements MetOfficeInterface
{
    public function siteSpecific(string $apiKey): SiteSpecificInterface
    {
        return new SiteSpecific($apiKey);
    }
}
