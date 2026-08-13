<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Model;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\AxisInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\Domain;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Domain::class)]
final class DomainTest extends TestCase
{
    public function test(): void
    {
        $axes = [
            't' => self::createStub(AxisInterface::class),
            'x' => self::createStub(AxisInterface::class),
        ];

        $domain = new Domain();
        self::assertSame([], $domain->getAxes());

        self::assertSame($domain, $domain->setAxes($axes));

        self::assertSame($axes, $domain->getAxes());
    }
}
