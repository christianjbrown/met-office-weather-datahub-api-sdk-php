<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Model;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RunDetail;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RunDetail::class)]
final class RunDetailTest extends TestCase
{
    public function test(): void
    {
        $runDetail = new RunDetail(123);
        self::assertSame(123, $runDetail->getRunDateTime());
        self::assertNull($runDetail->getRun());
        self::assertNull($runDetail->getRunFilter());

        self::assertSame($runDetail, $runDetail->setRunDateTime(456));
        self::assertSame($runDetail, $runDetail->setRun('06'));
        self::assertSame($runDetail, $runDetail->setRunFilter('2021012506'));

        self::assertSame(456, $runDetail->getRunDateTime());
        self::assertSame('06', $runDetail->getRun());
        self::assertSame('2021012506', $runDetail->getRunFilter());
    }
}
