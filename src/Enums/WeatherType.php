<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Enums;

enum WeatherType: int
{
    case CLEAR_NIGHT = 0;
    case CLOUDY = 7;
    case DRIZZLE = 11;
    case FOG = 6;
    case HAIL = 21;
    case HAIL_SHOWER_DAY = 20;
    case HAIL_SHOWER_NIGHT = 19;
    case HEAVY_RAIN = 15;
    case HEAVY_RAIN_SHOWER_DAY = 14;
    case HEAVY_RAIN_SHOWER_NIGHT = 13;
    case HEAVY_SNOW = 27;
    case HEAVY_SNOW_SHOWER_DAY = 26;
    case HEAVY_SNOW_SHOWER_NIGHT = 25;
    case LIGHT_RAIN = 12;
    case LIGHT_RAIN_SHOWER_DAY = 10;
    case LIGHT_RAIN_SHOWER_NIGHT = 9;
    case LIGHT_SNOW = 24;
    case LIGHT_SNOW_SHOWER_DAY = 23;
    case LIGHT_SNOW_SHOWER_NIGHT = 22;
    case MIST = 5;
    case NOT_USED = 4;
    case OVERCAST = 8;
    case PARTLY_CLOUDY_DAY = 3;
    case PARTLY_CLOUDY_NIGHT = 2;
    case SLEET = 18;
    case SLEET_SHOWER_DAY = 17;
    case SLEET_SHOWER_NIGHT = 16;
    case SUNNY_DAY = 1;
    case THUNDER = 30;
    case THUNDER_SHOWER_DAY = 29;
    case THUNDER_SHOWER_NIGHT = 28;
    case TRACE_RAIN = -1;
}
