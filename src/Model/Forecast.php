<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Model;

final class Forecast implements ForecastInterface
{
    private ?string $locationName = null;
    private ?int $modelRunDate = null;

    /**
     * @var array<int, ForecastTimeStepInterface>
     */
    private array $timeSteps = [];

    public function addTimeStep(ForecastTimeStepInterface $value): ForecastInterface
    {
        $this->timeSteps[] = $value;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->locationName;
    }

    public function getModelRunDate(): ?int
    {
        return $this->modelRunDate;
    }

    /**
     * @return array<int, ForecastTimeStepInterface>
     */
    public function getTimeSteps(): array
    {
        return $this->timeSteps;
    }

    public function setLocationName(?string $value): ForecastInterface
    {
        $this->locationName = $value;

        return $this;
    }

    public function setModelRunDate(?int $value): ForecastInterface
    {
        $this->modelRunDate = $value;

        return $this;
    }

    /**
     * @param array<int, ForecastTimeStepInterface> $value
     */
    public function setTimeSteps(array $value): ForecastInterface
    {
        $this->timeSteps = $value;

        return $this;
    }
}
