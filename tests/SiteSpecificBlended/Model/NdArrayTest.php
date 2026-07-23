<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Model;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NdArray::class)]
final class NdArrayTest extends TestCase
{
    public function test(): void
    {
        $axisNames = ['t'];
        $shape = [48];
        $values = [12.3, null, 13.1];

        $ndArray = new NdArray('feels_like_temperature');
        self::assertSame([], $ndArray->getAxisNames());
        self::assertNull($ndArray->getDataType());
        self::assertSame('feels_like_temperature', $ndArray->getId());
        self::assertSame([], $ndArray->getShape());
        self::assertSame([], $ndArray->getValues());

        self::assertSame($ndArray, $ndArray->setAxisNames($axisNames));
        self::assertSame($ndArray, $ndArray->setDataType('float'));
        self::assertSame($ndArray, $ndArray->setId('screen_temperature'));
        self::assertSame($ndArray, $ndArray->setShape($shape));
        self::assertSame($ndArray, $ndArray->setValues($values));

        self::assertSame($axisNames, $ndArray->getAxisNames());
        self::assertSame('float', $ndArray->getDataType());
        self::assertSame('screen_temperature', $ndArray->getId());
        self::assertSame($shape, $ndArray->getShape());
        self::assertSame($values, $ndArray->getValues());
    }
}
