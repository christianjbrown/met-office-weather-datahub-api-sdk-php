<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\AtmosphericModels\Model;

final class RunDetail implements RunDetailInterface
{
    private ?string $run = null;
    private int $runDateTime;
    private ?string $runFilter = null;

    public function __construct(int $runDateTime)
    {
        $this->runDateTime = $runDateTime;
    }

    public function getRun(): ?string
    {
        return $this->run;
    }

    public function getRunDateTime(): int
    {
        return $this->runDateTime;
    }

    public function getRunFilter(): ?string
    {
        return $this->runFilter;
    }

    public function setRun(?string $value): RunDetailInterface
    {
        $this->run = $value;

        return $this;
    }

    public function setRunDateTime(int $value): RunDetailInterface
    {
        $this->runDateTime = $value;

        return $this;
    }

    public function setRunFilter(?string $value): RunDetailInterface
    {
        $this->runFilter = $value;

        return $this;
    }
}
