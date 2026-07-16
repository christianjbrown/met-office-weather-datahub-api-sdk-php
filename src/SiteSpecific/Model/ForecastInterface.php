<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecific\Model;

interface ForecastInterface
{
    public function addTimeStep(ForecastTimeStepInterface $value): self;

    public function getLocationName(): ?string;

    public function getModelRunDate(): ?int;

    /**
     * @return array<int, ForecastTimeStepInterface>
     */
    public function getTimeSteps(): array;

    public function setLocationName(?string $value): self;

    public function setModelRunDate(?int $value): self;

    /**
     * @param array<int, ForecastTimeStepInterface> $value
     */
    public function setTimeSteps(array $value): self;
}
