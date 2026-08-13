<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Api;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\LandingPageInterface;

interface CapabilitiesApiInterface extends ApiInterface
{
    /**
     * @return array<int, string>
     */
    public function getConformance(): array;

    public function getLandingPage(): LandingPageInterface;
}
