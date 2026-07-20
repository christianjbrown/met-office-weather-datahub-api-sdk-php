<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

interface ApiKeyInterface
{
    public const HEADER_KEY_API_KEY = 'apikey';

    /**
     * @return array<string, string>
     */
    public function toHeaders(): array;
}
