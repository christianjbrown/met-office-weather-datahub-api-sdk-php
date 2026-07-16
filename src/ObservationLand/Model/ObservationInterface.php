<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\ObservationLand\Model;

use ChristianBrown\MetOffice\Enums\WeatherType;
use ChristianBrown\MetOffice\Enums\WindDirection;

interface ObservationInterface
{
    public function getDatetime(): int;

    public function getHumidity(): ?int;

    public function getMslp(): ?int;

    public function getPressureTendency(): ?string;

    public function getTemperature(): ?float;

    public function getVisibility(): ?float;

    public function getWeatherCode(): ?WeatherType;

    public function getWindDirection(): ?WindDirection;

    public function getWindGust(): ?float;

    public function getWindSpeed(): ?float;

    public function setDatetime(int $value): self;

    public function setHumidity(?int $value): self;

    public function setMslp(?int $value): self;

    public function setPressureTendency(?string $value): self;

    public function setTemperature(?float $value): self;

    public function setVisibility(?float $value): self;

    public function setWeatherCode(?WeatherType $value): self;

    public function setWindDirection(?WindDirection $value): self;

    public function setWindGust(?float $value): self;

    public function setWindSpeed(?float $value): self;
}
