<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Transformer;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Transformer\WeatherTypeTransformer;
use ChristianBrown\MetOffice\Transformer\WeatherTypeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(WeatherTypeTransformer::class)]
final class WeatherTypeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new WeatherTypeTransformer();

        self::assertSame(WeatherTypeTransformerInterface::WEATHER_TYPE_NAMES[WeatherType::SUNNY_DAY->value], $transformer->transform(WeatherType::SUNNY_DAY));
    }

    public function testTransformToEmoji(): void
    {
        $transformer = new WeatherTypeTransformer();

        self::assertSame(WeatherTypeTransformerInterface::WEATHER_TYPE_EMOJIS[WeatherType::SUNNY_DAY->value], $transformer->transformToEmoji(WeatherType::SUNNY_DAY));
    }

    public function testTransformToEmojiUnmappedReturnsNull(): void
    {
        $transformer = new WeatherTypeTransformer();

        self::assertNull($transformer->transformToEmoji(WeatherType::NOT_USED));
    }

    public function testTransformUnmappedReturnsNull(): void
    {
        $transformer = new WeatherTypeTransformer();

        self::assertNull($transformer->transform(WeatherType::NOT_USED));
    }
}
