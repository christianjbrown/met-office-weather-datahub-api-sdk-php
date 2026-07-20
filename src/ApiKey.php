<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

final class ApiKey implements ApiKeyInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return array<string, string>
     */
    public function toHeaders(): array
    {
        return [self::HEADER_KEY_API_KEY => $this->value];
    }
}
