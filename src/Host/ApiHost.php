<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Host;

use ChristianBrown\MetOffice\ApiInterface;

use function str_replace;

final class ApiHost implements ApiHostInterface
{
    private string $host;

    public function __construct(string $host = ApiInterface::API_HOST)
    {
        $this->host = $host;
    }

    public function rewrite(string $url): string
    {
        return str_replace(ApiInterface::API_HOST, $this->host, $url);
    }
}
