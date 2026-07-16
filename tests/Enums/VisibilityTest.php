<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Enums;

use ChristianBrown\MetOffice\Enums\Visibility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Visibility::class)]
final class VisibilityTest extends TestCase
{
    #[TestWith(['EX', Visibility::EXCELLENT])]
    #[TestWith(['GO', Visibility::GOOD])]
    #[TestWith(['MO', Visibility::MODERATE])]
    #[TestWith(['PO', Visibility::POOR])]
    #[TestWith(['UN', Visibility::UNKNOWN])]
    #[TestWith(['VG', Visibility::VERY_GOOD])]
    #[TestWith(['VP', Visibility::VERY_POOR])]
    public function testFrom(string $value, Visibility $expected): void
    {
        self::assertSame($expected, Visibility::from($value));
    }
}
