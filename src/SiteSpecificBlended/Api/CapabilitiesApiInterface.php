<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Api;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LandingPageInterface;

interface CapabilitiesApiInterface extends ApiInterface
{
    /**
     * @return array<int, string>
     */
    public function getConformance(): array;

    public function getLandingPage(): LandingPageInterface;
}
