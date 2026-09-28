<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

final class Forecast implements ForecastInterface
{
    private ?float $elevation = null;
    private ?string $locationLicence = null;
    private ?string $locationName = null;
    private ?int $modelRunDate = null;

    /**
     * @var array<array-key, ParameterMetadataInterface>
     */
    private array $parameters = [];
    private ?float $requestPointDistance = null;

    /**
     * @var array<int, ForecastTimeStepInterface>
     */
    private array $timeSteps = [];

    public function addTimeStep(ForecastTimeStepInterface $value): ForecastInterface
    {
        $this->timeSteps[] = $value;

        return $this;
    }

    public function getElevation(): ?float
    {
        return $this->elevation;
    }

    public function getLocationLicence(): ?string
    {
        return $this->locationLicence;
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
     * @return array<array-key, ParameterMetadataInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getRequestPointDistance(): ?float
    {
        return $this->requestPointDistance;
    }

    /**
     * @return array<int, ForecastTimeStepInterface>
     */
    public function getTimeSteps(): array
    {
        return $this->timeSteps;
    }

    public function setElevation(?float $value): ForecastInterface
    {
        $this->elevation = $value;

        return $this;
    }

    public function setLocationLicence(?string $value): ForecastInterface
    {
        $this->locationLicence = $value;

        return $this;
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
     * @param array<array-key, ParameterMetadataInterface> $value
     */
    public function setParameters(array $value): ForecastInterface
    {
        $this->parameters = $value;

        return $this;
    }

    public function setRequestPointDistance(?float $value): ForecastInterface
    {
        $this->requestPointDistance = $value;

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
