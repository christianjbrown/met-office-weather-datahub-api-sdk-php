<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Host;

interface ApiHostInterface
{
    /**
     * Rewrites a production DataHub URL onto this host, leaving the path and
     * query untouched. Given the production URL unchanged, returns it as-is.
     */
    public function rewrite(string $url): string;
}
