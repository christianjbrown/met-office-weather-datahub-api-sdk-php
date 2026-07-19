<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Model;

use ChristianBrown\MetOffice\Coverage\Model\Run;
use ChristianBrown\MetOffice\Coverage\Model\RunDetailInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Run::class)]
final class RunTest extends TestCase
{
    public function test(): void
    {
        $runDetail = self::createStub(RunDetailInterface::class);
        $completeRuns = [$runDetail];

        $run = new Run('mo-global');
        self::assertSame('mo-global', $run->getModelId());
        self::assertSame([], $run->getCompleteRuns());

        self::assertSame($run, $run->setModelId('mo-uk'));
        self::assertSame($run, $run->setCompleteRuns($completeRuns));

        self::assertSame('mo-uk', $run->getModelId());
        self::assertSame($completeRuns, $run->getCompleteRuns());
    }
}
