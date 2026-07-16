<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Exception;

use ChristianBrown\MetOffice\Exception\ExceptionInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(UnexpectedResponseException::class)]
final class UnexpectedResponseExceptionTest extends TestCase
{
    public function test(): void
    {
        $exception = new UnexpectedResponseException('test-message');

        self::assertInstanceOf(UnexpectedResponseExceptionInterface::class, $exception);
        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertInstanceOf(RuntimeException::class, $exception);
        self::assertSame('test-message', $exception->getMessage());
    }
}
