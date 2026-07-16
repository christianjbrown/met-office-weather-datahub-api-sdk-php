<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\SiteSpecific\SiteSpecificInterface;

interface MetOfficeInterface
{
    public function siteSpecific(string $apiKey): SiteSpecificInterface;
}
