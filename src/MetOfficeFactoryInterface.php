<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

use ChristianBrown\MetOffice\Host\ApiHostInterface;

interface MetOfficeFactoryInterface
{
    /**
     * Builds a MetOffice that talks to the live DataHub host.
     */
    public function create(): MetOfficeInterface;

    /**
     * Builds a MetOffice that rewrites every request to the given host.
     */
    public function createWithHost(ApiHostInterface $apiHost): MetOfficeInterface;
}
