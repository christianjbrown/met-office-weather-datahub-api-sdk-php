<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

interface AxisInterface
{
    /**
     * @return array<int, string>
     */
    public function getBounds(): array;

    /**
     * @return array<int, float>
     */
    public function getFloatValues(): array;

    public function getName(): string;

    /**
     * @return array<int, string>
     */
    public function getStringValues(): array;

    /**
     * @param array<int, string> $value
     */
    public function setBounds(array $value): self;

    /**
     * @param array<int, float> $value
     */
    public function setFloatValues(array $value): self;

    public function setName(string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setStringValues(array $value): self;
}
