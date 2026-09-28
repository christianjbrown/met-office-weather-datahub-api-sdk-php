<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

interface ForecastInterface
{
    public function addTimeStep(ForecastTimeStepInterface $value): self;

    public function getElevation(): ?float;

    public function getLocationLicence(): ?string;

    public function getLocationName(): ?string;

    public function getModelRunDate(): ?int;

    /**
     * @return array<array-key, ParameterMetadataInterface>
     */
    public function getParameters(): array;

    public function getRequestPointDistance(): ?float;

    /**
     * @return array<int, ForecastTimeStepInterface>
     */
    public function getTimeSteps(): array;

    public function setElevation(?float $value): self;

    public function setLocationLicence(?string $value): self;

    public function setLocationName(?string $value): self;

    public function setModelRunDate(?int $value): self;

    /**
     * @param array<array-key, ParameterMetadataInterface> $value
     */
    public function setParameters(array $value): self;

    public function setRequestPointDistance(?float $value): self;

    /**
     * @param array<int, ForecastTimeStepInterface> $value
     */
    public function setTimeSteps(array $value): self;
}
