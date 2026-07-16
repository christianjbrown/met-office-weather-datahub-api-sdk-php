<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

final class ParameterDetail implements ParameterDetailInterface
{
    private string $parameterId;

    /**
     * @var array<int, string>
     */
    private array $timeCoordinates = [];

    /**
     * @var array<int, float>
     */
    private array $verticalCoordinates = [];

    public function __construct(string $parameterId)
    {
        $this->parameterId = $parameterId;
    }

    public function getParameterId(): string
    {
        return $this->parameterId;
    }

    /**
     * @return array<int, string>
     */
    public function getTimeCoordinates(): array
    {
        return $this->timeCoordinates;
    }

    /**
     * @return array<int, float>
     */
    public function getVerticalCoordinates(): array
    {
        return $this->verticalCoordinates;
    }

    public function setParameterId(string $value): ParameterDetailInterface
    {
        $this->parameterId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setTimeCoordinates(array $value): ParameterDetailInterface
    {
        $this->timeCoordinates = $value;

        return $this;
    }

    /**
     * @param array<int, float> $value
     */
    public function setVerticalCoordinates(array $value): ParameterDetailInterface
    {
        $this->verticalCoordinates = $value;

        return $this;
    }
}
