<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Enums;

use function round;

enum WindDirection: string
{
    case EAST = 'E';
    case EAST_NORTH_EAST = 'ENE';
    case EAST_SOUTH_EAST = 'ESE';
    case NORTH = 'N';
    case NORTH_EAST = 'NE';
    case NORTH_NORTH_EAST = 'NNE';
    case NORTH_NORTH_WEST = 'NNW';
    case NORTH_WEST = 'NW';
    case SOUTH = 'S';
    case SOUTH_EAST = 'SE';
    case SOUTH_SOUTH_EAST = 'SSE';
    case SOUTH_SOUTH_WEST = 'SSW';
    case SOUTH_WEST = 'SW';
    case WEST = 'W';
    case WEST_NORTH_WEST = 'WNW';
    case WEST_SOUTH_WEST = 'WSW';

    /**
     * Maps a compass bearing in degrees (0 = North, increasing clockwise) to the
     * nearest of the 16 points of the compass. Bearings outside 0-359 are
     * normalised, so 360, 720 and -10 all resolve as expected.
     */
    public static function fromDegrees(int $degrees): self
    {
        $points = [
            self::NORTH,
            self::NORTH_NORTH_EAST,
            self::NORTH_EAST,
            self::EAST_NORTH_EAST,
            self::EAST,
            self::EAST_SOUTH_EAST,
            self::SOUTH_EAST,
            self::SOUTH_SOUTH_EAST,
            self::SOUTH,
            self::SOUTH_SOUTH_WEST,
            self::SOUTH_WEST,
            self::WEST_SOUTH_WEST,
            self::WEST,
            self::WEST_NORTH_WEST,
            self::NORTH_WEST,
            self::NORTH_NORTH_WEST,
        ];
        $normalised = (($degrees % 360) + 360) % 360;
        $index = (int) round($normalised / 22.5) % 16;

        return $points[$index];
    }
}
