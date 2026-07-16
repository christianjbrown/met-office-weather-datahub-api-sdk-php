<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Model;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileDetails;
use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Model\ParameterDetailInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderFileDetails::class)]
final class OrderFileDetailsTest extends TestCase
{
    public function test(): void
    {
        $file = self::createStub(OrderFileInterface::class);
        $otherFile = self::createStub(OrderFileInterface::class);
        $parameterDetail = self::createStub(ParameterDetailInterface::class);
        $parameterDetails = [$parameterDetail];

        $orderFileDetails = new OrderFileDetails($file);
        self::assertSame($file, $orderFileDetails->getFile());
        self::assertSame([], $orderFileDetails->getParameterDetails());

        self::assertSame($orderFileDetails, $orderFileDetails->setFile($otherFile));
        self::assertSame($orderFileDetails, $orderFileDetails->setParameterDetails($parameterDetails));

        self::assertSame($otherFile, $orderFileDetails->getFile());
        self::assertSame($parameterDetails, $orderFileDetails->getParameterDetails());
    }
}
