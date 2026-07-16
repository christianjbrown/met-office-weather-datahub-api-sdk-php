<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Model;

interface ParameterDetailInterface
{
    public function getParameterId(): string;

    /**
     * @return array<int, string>
     */
    public function getTimeCoordinates(): array;

    /**
     * @return array<int, float>
     */
    public function getVerticalCoordinates(): array;

    public function setParameterId(string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setTimeCoordinates(array $value): self;

    /**
     * @param array<int, float> $value
     */
    public function setVerticalCoordinates(array $value): self;
}
