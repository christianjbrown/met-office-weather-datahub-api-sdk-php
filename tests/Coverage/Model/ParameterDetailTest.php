<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Model;

use ChristianBrown\MetOffice\Coverage\Model\ParameterDetail;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParameterDetail::class)]
final class ParameterDetailTest extends TestCase
{
    public function test(): void
    {
        $timeCoordinates = ['2020-02-19T12:00:00.000Z'];
        $verticalCoordinates = [100000.0];

        $parameterDetail = new ParameterDetail('temperature');
        self::assertSame('temperature', $parameterDetail->getParameterId());
        self::assertSame([], $parameterDetail->getTimeCoordinates());
        self::assertSame([], $parameterDetail->getVerticalCoordinates());

        self::assertSame($parameterDetail, $parameterDetail->setParameterId('humidity'));
        self::assertSame($parameterDetail, $parameterDetail->setTimeCoordinates($timeCoordinates));
        self::assertSame($parameterDetail, $parameterDetail->setVerticalCoordinates($verticalCoordinates));

        self::assertSame('humidity', $parameterDetail->getParameterId());
        self::assertSame($timeCoordinates, $parameterDetail->getTimeCoordinates());
        self::assertSame($verticalCoordinates, $parameterDetail->getVerticalCoordinates());
    }
}
