<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests;

use ChristianBrown\MetOffice\ApiKey;
use ChristianBrown\MetOffice\ApiKeyInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiKey::class)]
final class ApiKeyTest extends TestCase
{
    public function testToHeaders(): void
    {
        $apiKey = new ApiKey('test-api-key');

        self::assertSame([ApiKeyInterface::HEADER_KEY_API_KEY => 'test-api-key'], $apiKey->toHeaders());
    }
}
