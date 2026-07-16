<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;

final class WeatherTypeTransformer implements WeatherTypeTransformerInterface
{
    public function transform(WeatherType $weatherType): ?string
    {
        $type = null;
        if (!empty(self::WEATHER_TYPE_NAMES[$weatherType->value])) {
            $type = self::WEATHER_TYPE_NAMES[$weatherType->value];
        }

        return $type;
    }

    public function transformToEmoji(WeatherType $weatherType): ?string
    {
        $emoji = null;
        if (!empty(self::WEATHER_TYPE_EMOJIS[$weatherType->value])) {
            $emoji = self::WEATHER_TYPE_EMOJIS[$weatherType->value];
        }

        return $emoji;
    }
}
