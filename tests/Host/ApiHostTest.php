<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Host;

use ChristianBrown\MetOffice\ApiInterface;
use ChristianBrown\MetOffice\Host\ApiHost;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiHost::class)]
final class ApiHostTest extends TestCase
{
    public function testCustomHostReplacesTheProductionHost(): void
    {
        $apiHost = new ApiHost('https://sandbox.example');

        self::assertSame(
            'https://sandbox.example/sitespecific/v0/point/hourly',
            $apiHost->rewrite(ApiInterface::API_HOST.'/sitespecific/v0/point/hourly')
        );
    }

    public function testDefaultHostLeavesProductionUrlsUnchanged(): void
    {
        $apiHost = new ApiHost();

        self::assertSame(
            'https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/hourly',
            $apiHost->rewrite('https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/hourly')
        );
    }
}
