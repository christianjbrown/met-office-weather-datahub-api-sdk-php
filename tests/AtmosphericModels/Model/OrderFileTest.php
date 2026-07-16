<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Model;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFile;
use ChristianBrown\MetOffice\AtmosphericModels\Model\RegionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderFile::class)]
final class OrderFileTest extends TestCase
{
    public function test(): void
    {
        $region = self::createStub(RegionInterface::class);
        $levels = ['100000'];
        $parameters = ['temperature'];
        $timesteps = ['0', '3'];

        $orderFile = new OrderFile('isbl_temperature_100000_+00');
        self::assertSame('isbl_temperature_100000_+00', $orderFile->getFileId());
        self::assertNull($orderFile->getSurfaceId());
        self::assertNull($orderFile->getRun());
        self::assertNull($orderFile->getRunDateTime());
        self::assertNull($orderFile->getRegion());
        self::assertSame([], $orderFile->getLevels());
        self::assertSame([], $orderFile->getParameters());
        self::assertSame([], $orderFile->getTimesteps());

        self::assertSame($orderFile, $orderFile->setFileId('other'));
        self::assertSame($orderFile, $orderFile->setSurfaceId('isbl'));
        self::assertSame($orderFile, $orderFile->setRun('12'));
        self::assertSame($orderFile, $orderFile->setRunDateTime(1582113600));
        self::assertSame($orderFile, $orderFile->setRegion($region));
        self::assertSame($orderFile, $orderFile->setLevels($levels));
        self::assertSame($orderFile, $orderFile->setParameters($parameters));
        self::assertSame($orderFile, $orderFile->setTimesteps($timesteps));

        self::assertSame('other', $orderFile->getFileId());
        self::assertSame('isbl', $orderFile->getSurfaceId());
        self::assertSame('12', $orderFile->getRun());
        self::assertSame(1582113600, $orderFile->getRunDateTime());
        self::assertSame($region, $orderFile->getRegion());
        self::assertSame($levels, $orderFile->getLevels());
        self::assertSame($parameters, $orderFile->getParameters());
        self::assertSame($timesteps, $orderFile->getTimesteps());
    }
}
