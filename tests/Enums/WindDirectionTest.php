<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Enums;

use ChristianBrown\MetOffice\Enums\WindDirection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(WindDirection::class)]
final class WindDirectionTest extends TestCase
{
    #[TestWith(['N', WindDirection::NORTH])]
    #[TestWith(['NNE', WindDirection::NORTH_NORTH_EAST])]
    #[TestWith(['ENE', WindDirection::EAST_NORTH_EAST])]
    #[TestWith(['SSW', WindDirection::SOUTH_SOUTH_WEST])]
    public function testFrom(string $value, WindDirection $expected): void
    {
        self::assertSame($expected, WindDirection::from($value));
    }

    /**
     * Every one of the 16 sector centres, plus the wrap-around cases at 360/720,
     * negative bearings, and the NNE/N boundary either side of 11.25 degrees.
     */
    #[TestWith([0, WindDirection::NORTH])]
    #[TestWith([23, WindDirection::NORTH_NORTH_EAST])]
    #[TestWith([45, WindDirection::NORTH_EAST])]
    #[TestWith([68, WindDirection::EAST_NORTH_EAST])]
    #[TestWith([90, WindDirection::EAST])]
    #[TestWith([113, WindDirection::EAST_SOUTH_EAST])]
    #[TestWith([135, WindDirection::SOUTH_EAST])]
    #[TestWith([158, WindDirection::SOUTH_SOUTH_EAST])]
    #[TestWith([180, WindDirection::SOUTH])]
    #[TestWith([203, WindDirection::SOUTH_SOUTH_WEST])]
    #[TestWith([225, WindDirection::SOUTH_WEST])]
    #[TestWith([248, WindDirection::WEST_SOUTH_WEST])]
    #[TestWith([270, WindDirection::WEST])]
    #[TestWith([293, WindDirection::WEST_NORTH_WEST])]
    #[TestWith([315, WindDirection::NORTH_WEST])]
    #[TestWith([338, WindDirection::NORTH_NORTH_WEST])]
    #[TestWith([349, WindDirection::NORTH])]
    #[TestWith([360, WindDirection::NORTH])]
    #[TestWith([720, WindDirection::NORTH])]
    #[TestWith([11, WindDirection::NORTH])]
    #[TestWith([12, WindDirection::NORTH_NORTH_EAST])]
    #[TestWith([-10, WindDirection::NORTH])]
    #[TestWith([-90, WindDirection::WEST])]
    #[TestWith([-180, WindDirection::SOUTH])]
    public function testFromDegrees(int $degrees, WindDirection $expected): void
    {
        self::assertSame($expected, WindDirection::fromDegrees($degrees));
    }
}
